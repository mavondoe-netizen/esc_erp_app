<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * LeasePayments Controller — Records rental payments and auto-posts to the ledger.
 */
class LeasePaymentsController extends AppController
{
    public function index()
    {
        $query = $this->fetchTable('LeasePayments')->find()
            ->contain(['Tenants', 'Units', 'Buildings', 'Accounts'])
            ->order(['date' => 'DESC']);
        $leasePayments = $this->paginate($query);
        $this->set(compact('leasePayments'));
    }

    public function view($id = null)
    {
        $leasePayment = $this->fetchTable('LeasePayments')->get($id, contain: ['Tenants', 'Units', 'Buildings', 'Accounts', 'Enrolments']);
        $this->set(compact('leasePayment'));
    }

    public function add()
    {
        $leasePayment = $this->fetchTable('LeasePayments')->newEmptyEntity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $leasePayment->company_id = $companyId;
        $leasePayment->currency = 'USD';
        $leasePayment->date = date('Y-m-d');
        $leasePayment->period_covered = date('F Y');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['company_id'] = $companyId;
            $leasePayment = $this->fetchTable('LeasePayments')->patchEntity($leasePayment, $data);

            if ($this->fetchTable('LeasePayments')->save($leasePayment)) {
                // --- DOUBLE-ENTRY LEDGER POST ---
                $txTable = $this->fetchTable('Transactions');
                $txGroup = Text::uuid();
                $amount = (float)$leasePayment->amount;
                $date   = $leasePayment->date;
                $desc   = 'Rental ' . ($leasePayment->period_covered ?? '') . ' – ' . ($leasePayment->reference ?? 'Receipt');
                $currency = $leasePayment->currency ?? 'USD';

                // Find Rental Income account by name
                $incomeAccount = $this->fetchTable('Accounts')->find()
                    ->where(['name LIKE' => '%Rental Income%'])
                    ->first();
                $incomeAccountId = $incomeAccount ? $incomeAccount->id : null;

                // Find cash/bank account selected
                $bankAccountId = $leasePayment->account_id;

                if ($bankAccountId && $incomeAccountId) {
                    // Debit Cash/Bank (Asset increases)
                    $txTable->save($txTable->newEntity([
                        'date'              => $date,
                        'description'       => $desc,
                        'amount'            => $amount,
                        'zwg'               => $amount,
                        'currency'          => $currency,
                        'account_id'        => $bankAccountId,
                        'company_id'        => $companyId,
                        'tenant_id'         => $leasePayment->tenant_id,
                        'building_id'       => $leasePayment->building_id,
                        'type'              => '2', // Debit
                        'transaction_group' => $txGroup,
                    ]));
                    // Credit Rental Income (Revenue increases)
                    $txTable->save($txTable->newEntity([
                        'date'              => $date,
                        'description'       => $desc,
                        'amount'            => $amount,
                        'zwg'               => $amount,
                        'currency'          => $currency,
                        'account_id'        => $incomeAccountId,
                        'company_id'        => $companyId,
                        'tenant_id'         => $leasePayment->tenant_id,
                        'building_id'       => $leasePayment->building_id,
                        'type'              => '1', // Credit
                        'transaction_group' => $txGroup,
                    ]));
                }

                $this->Flash->success(__('Rental payment recorded and posted to ledger.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please try again.'));
        }

        $tenants   = $this->fetchTable('Tenants')->find('list')->all();
        $units     = $this->fetchTable('Units')->find('list')->all();
        $buildings = $this->fetchTable('Buildings')->find('list')->all();
        $accounts  = $this->fetchTable('Accounts')->find('list', ['conditions' => ['category IN' => ['Asset', 'Bank']]])->all();
        $enrolments = $this->fetchTable('Enrolments')->find('list')->where(['status' => 'Active'])->all();
        $paymentModes = ['Cash' => 'Cash', 'Bank Transfer' => 'Bank Transfer', 'EcoCash' => 'EcoCash', 'Mobile Money' => 'Mobile Money'];
        $currencies = ['USD' => 'USD', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR'];

        $this->set(compact('leasePayment', 'tenants', 'units', 'buildings', 'accounts', 'enrolments', 'paymentModes', 'currencies'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leasePayment = $this->fetchTable('LeasePayments')->get($id);
        if ($this->fetchTable('LeasePayments')->delete($leasePayment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
