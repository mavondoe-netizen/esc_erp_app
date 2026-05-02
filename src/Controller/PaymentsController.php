<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;
use Cake\Mailer\MailerAwareTrait;

/**
 * Payments Controller
 *
 * Supplier bill payments — records cash paid against a bill
 * and posts the corresponding ledger entries (Debit AP, Credit Bank).
 */
class PaymentsController extends AppController
{
    use MailerAwareTrait;
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Payments = $this->fetchTable('Payments');
        $query    = $Payments->find()
            ->where(['Payments.company_id' => $companyId])
            ->contain(['Suppliers', 'Accounts'])
            ->order(['Payments.date' => 'DESC']);

        $payments = $this->paginate($query, ['limit' => 50]);
        $suppliers = $this->fetchTable('Suppliers');
        $this->set(compact('payments', 'suppliers'));
    }

    public function view(int $id)
    {
        $this->viewBuilder()->setLayout('document');
        $companyId = $this->request->getAttribute('company_id');
        $payment = $this->fetchTable('Payments')
            ->get($id, contain: ['Suppliers', 'Accounts', 'Transactions' => ['Accounts']]);
        
        $company = $this->fetchTable('Companies')->get($companyId);
        
        $this->set(compact('payment', 'company'));
    }

    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Payments = $this->fetchTable('Payments');
        $payment  = $Payments->newEmptyEntity();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['company_id'] = $companyId;
            $data['status']     = $data['status'] ?? 'Approved'; // Default to approved for payments
            $payment = $Payments->patchEntity($payment, $data);

            if ($this->request->getQuery('popup')) {
                if ($Payments->save($payment)) {
                    $this->set('popupResult', ['id' => $payment->id, 'name' => "PMT-{$payment->id}"]);
                    $this->viewBuilder()->disableAutoLayout();
                    return $this->render('/Element/popup_success');
                }
            }

            if ($Payments->save($payment)) {
                if ($payment->status === 'Approved') {
                    $this->_postPaymentToLedger($payment, $companyId);
                }
                $this->_sendPaymentEmail($payment->id);
                $this->Flash->success(__('Payment saved.'));
                return $this->redirect(['action' => 'view', $payment->id]);
            }
            $this->Flash->error(__('Could not save payment.'));
        }

        [$suppliers, $accounts] = $this->_dropdowns($companyId);
        $this->set(compact('payment', 'suppliers', 'accounts'));
    }

    public function edit(int $id)
    {
        $companyId = $this->request->getAttribute('company_id');

        $Payments = $this->fetchTable('Payments');
        $payment  = $Payments->get($id);

        if ($this->request->is(['post', 'put'])) {
            $payment = $Payments->patchEntity($payment, $this->request->getData());
            if ($Payments->save($payment)) {
                // Reverse and re-post
                $this->_reversePaymentLedger($payment->id, $companyId);
                if ($payment->status === 'Approved') {
                    $this->_postPaymentToLedger($payment, $companyId);
                }
                
                $this->Flash->success(__('Payment updated.'));
                return $this->redirect(['action' => 'view', $payment->id]);
            }
            $this->Flash->error(__('Could not update payment.'));
        }

        [$suppliers, $accounts] = $this->_dropdowns($companyId);
        $this->set(compact('payment', 'suppliers', 'accounts'));
    }

    private function _postPaymentToLedger($payment, int $companyId): void
    {
        $Transactions = $this->fetchTable('Transactions');
        $Accounts     = $this->fetchTable('Accounts');
        $Rates        = $this->fetchTable('ExchangeRates');

        // Fetch current exchange rate for ZWG conversion
        $rate = $Rates->find()
            ->where(['company_id' => $companyId, 'currency' => $payment->currency])
            ->where(['date <=' => $payment->date ?: date('Y-m-d')])
            ->orderBy(['date' => 'DESC'])
            ->first();
        $rateVal = $rate ? (float)$rate->rate_to_base : 1.0;

        $apAccount = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.category LIKE' => '%Payable%'])
            ->first();

        if (!$apAccount) {
            $apAccount = $Accounts->newEntity([
                'name' => 'Accounts Payable',
                'category' => 'Accounts Payable',
                'type' => 'Liability',
                'company_id' => $companyId
            ]);
            $Accounts->save($apAccount);
        }

        $bankAccountId = $payment->account_id ?? null;
        if (!$bankAccountId) return;

        $date     = $payment->date ? $payment->date->format('Y-m-d') : date('Y-m-d');
        $amount   = (float)($payment->amount ?? 0);
        $currency = $payment->currency ?? 'USD';
        $groupId  = Text::uuid();
        $ref      = $payment->reference ?? "PMT-{$payment->id}";

        $Transactions->getConnection()->transactional(function () use (
            $Transactions, $payment, $apAccount, $bankAccountId,
            $date, $amount, $currency, $groupId, $ref, $companyId, $rateVal
        ) {
            // Debit: AP (reduces liability)
            $dr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Payment $ref",
                'currency'          => $currency,
                'amount'            => $amount,
                'zwg'               => $amount * $rateVal,
                'type'              => 'Debit',
                'account_id'        => $apAccount->id,
                'supplier_id'       => $payment->supplier_id ?? null,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($dr, ['check_balance' => false]);

            // Credit: Bank/cash account
            $cr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Payment $ref",
                'currency'          => $currency,
                'amount'            => $amount,
                'zwg'               => $amount * $rateVal,
                'type'              => 'Credit',
                'account_id'        => $bankAccountId,
                'supplier_id'       => $payment->supplier_id ?? null,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($cr, ['check_balance' => false]);
        });
    }

    private function _reversePaymentLedger(int $paymentId, int $companyId): void
    {
        $Transactions = $this->fetchTable('Transactions');
        $conn = $Transactions->getConnection();
        $stmt = $conn->execute(
            "SELECT DISTINCT transaction_group FROM transactions WHERE payment_id = :pid AND company_id = :cid",
            [':pid' => $paymentId, ':cid' => $companyId]
        );
        $groups = array_filter(array_column($stmt->fetchAll('assoc'), 'transaction_group'));
        if (!empty($groups)) {
            $Transactions->deleteAll(['transaction_group IN' => $groups, 'company_id' => $companyId]);
        }
    }

    private function _dropdowns(int $companyId): array
    {
        $suppliers = $this->fetchTable('Suppliers')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Suppliers.company_id' => $companyId])->all();

        $accounts = $this->fetchTable('Accounts')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Accounts.company_id' => $companyId])
            ->order(['Accounts.type', 'Accounts.name'])->all();

        return [$suppliers, $accounts];
    }

    /**
     * Helper to send payment email
     */
    private function _sendPaymentEmail(int $id): void
    {
        try {
            $payment = $this->fetchTable('Payments')->get($id, contain: ['Suppliers' => ['Contacts']]);
            $email = $payment->supplier->contact->email ?? null;

            if ($email) {
                $this->getMailer('Notification')->send('payment', [$payment->toArray(), $email]);
            }
        } catch (\Exception $e) {
            $this->Flash->warning(__('Payment saved, but email could not be sent: ' . $e->getMessage()));
        }
    }
}
