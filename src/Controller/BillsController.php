<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;
use Cake\Mailer\MailerAwareTrait;

/**
 * Bills Controller
 *
 * Accounts Payable — supplier bills, line-item management, and ledger posting.
 * Mirrors InvoicesController but posts to AP (Accounts Payable) instead of AR.
 */
class BillsController extends AppController
{
    use MailerAwareTrait;
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Bills = $this->fetchTable('Bills');

        $conditions = ['Bills.company_id' => $companyId];
        $status   = $this->request->getQuery('status');
        $from     = $this->request->getQuery('start_date');
        $to       = $this->request->getQuery('end_date');
        $supplier = $this->request->getQuery('supplier_id');

        if ($status)   $conditions['Bills.status']      = $status;
        if ($from)     $conditions['Bills.date >=']     = $from;
        if ($to)       $conditions['Bills.date <=']     = $to;
        if ($supplier) $conditions['Bills.supplier_id'] = (int)$supplier;

        $query = $Bills->find()
            ->where($conditions)
            ->contain(['Suppliers', 'Tenants'])
            ->order(['Bills.date' => 'DESC', 'Bills.id' => 'DESC']);

        $bills = $this->paginate($query, ['limit' => 50]);

        $suppliers = $this->fetchTable('Suppliers')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Suppliers.company_id' => $companyId])
            ->all();

        $this->set(compact('bills', 'suppliers'));
    }

    public function view(int $id)
    {
        $this->viewBuilder()->setLayout('document');
        $companyId = $this->request->getAttribute('company_id');

        $bill = $this->fetchTable('Bills')
            ->get($id, contain: ['Suppliers', 'Tenants', 'BillItems' => ['Accounts'], 'Transactions' => ['Accounts']]);

        $company = $this->fetchTable('Companies')->get($companyId);

        $this->set(compact('bill', 'company'));
    }

    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Bills = $this->fetchTable('Bills');
        $bill  = $Bills->newEmptyEntity();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['company_id'] = $companyId;
            $data['status']     = $data['status'] ?? 'Draft';
            $bill = $Bills->patchEntity($bill, $data, ['associated' => ['BillItems']]);

            if ($this->request->getQuery('popup')) {
                if ($Bills->save($bill)) {
                    $this->set('popupResult', ['id' => $bill->id, 'name' => $bill->reference ?? "BILL-{$bill->id}"]);
                    $this->viewBuilder()->disableAutoLayout();
                    return $this->render('/Element/popup_success');
                }
            }

            if ($Bills->save($bill)) {
                // Post-once: only push to ledger on first move out of Draft
                if (!in_array($bill->status, ['Draft', 'Pending'])) {
                    $this->_postBillToLedger($bill, $companyId);
                }
                
                if ($bill->status === 'Sent') {
                    $this->_sendBillEmail($bill->id);
                }

                $this->Flash->success(__('Bill saved.'));
                return $this->redirect(['action' => 'view', $bill->id]);
            }
            $this->Flash->error(__('Could not save bill.'));
        }

        $suppliers = $this->fetchTable('Suppliers')->find('list', keyField: 'id', valueField: 'name')->where(['Suppliers.company_id' => $companyId])->all();
        $tenants   = $this->fetchTable('Tenants')->find('list', keyField: 'id', valueField: 'name')->where(['Tenants.company_id' => $companyId])->all();
        $accounts  = $this->fetchTable('Accounts')->find('list', keyField: 'id', valueField: 'name')->where(['Accounts.company_id' => $companyId])->order(['Accounts.type', 'Accounts.name'])->all();
        
        $products = $this->fetchTable('Products')->find()
            ->where(['Products.company_id' => $companyId])
            ->all();

        $productsOptions = [];
        $productsJson = [];
        foreach ($products as $p) {
            $productsOptions[$p->id] = $p->name;
            $productsJson[$p->id] = [
                'unit_price' => (float)$p->unit_price,
                'account_id' => $p->account_id,
                'vat_rate'   => (float)$p->vat_rate,
                'hs_code'    => $p->hs_code,
                'vat_type'   => $p->vat_type ?: 'Standard'
            ];
        }

        $this->set(compact('bill', 'suppliers', 'tenants', 'accounts', 'productsOptions', 'productsJson'));
    }

    public function edit(int $id)
    {
        $companyId = $this->request->getAttribute('company_id');

        $Bills = $this->fetchTable('Bills');
        $bill  = $Bills->get($id, contain: ['BillItems']);

        // Post-once guard: was already posted (not Draft/Pending) before this edit?
        $wasPosted = !in_array($bill->status ?? 'Draft', ['Draft', 'Pending']);

        if ($this->request->is(['post', 'put'])) {
            $data      = $this->request->getData();
            $newStatus = $data['status'] ?? $bill->status;
            $bill      = $Bills->patchEntity($bill, $data, ['associated' => ['BillItems']]);

            if ($Bills->save($bill)) {
                // Always reverse previous transactions to ensure the ledger is in sync
                $this->_reverseBillLedger($bill->id, $companyId);

                // Re-post to ledger if status is not Draft or Pending
                if (!in_array($newStatus, ['Draft', 'Pending'])) {
                    $this->_postBillToLedger($bill, $companyId);
                }

                if ($bill->status === 'Sent') {
                    $this->_sendBillEmail($bill->id);
                }

                $this->Flash->success(__('Bill updated.'));
                return $this->redirect(['action' => 'view', $bill->id]);
            }
            $this->Flash->error(__('Could not update bill.'));
        }

        $suppliers = $this->fetchTable('Suppliers')->find('list', keyField: 'id', valueField: 'name')->where(['Suppliers.company_id' => $companyId])->all();
        $tenants   = $this->fetchTable('Tenants')->find('list', keyField: 'id', valueField: 'name')->where(['Tenants.company_id' => $companyId])->all();
        $accounts  = $this->fetchTable('Accounts')->find('list', keyField: 'id', valueField: 'name')->where(['Accounts.company_id' => $companyId])->order(['Accounts.type', 'Accounts.name'])->all();

        $products = $this->fetchTable('Products')->find()
            ->where(['Products.company_id' => $companyId])
            ->all();

        $productsOptions = [];
        $productsJson = [];
        foreach ($products as $p) {
            $productsOptions[$p->id] = $p->name;
            $productsJson[$p->id] = [
                'unit_price' => (float)$p->unit_price,
                'account_id' => $p->account_id,
                'vat_rate'   => (float)$p->vat_rate,
                'hs_code'    => $p->hs_code,
                'vat_type'   => $p->vat_type ?: 'Standard'
            ];
        }
        
        $this->set(compact('bill', 'suppliers', 'tenants', 'accounts', 'productsOptions', 'productsJson'));
    }

    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyId = $this->request->getAttribute('company_id');

        $Bills = $this->fetchTable('Bills');
        $bill  = $Bills->find()->where(['Bills.id' => $id, 'Bills.company_id' => $companyId])->first();

        if (!$bill) {
            $this->Flash->error(__('Bill not found.'));
            return $this->redirect(['action' => 'index']);
        }

        // Reverse ledger entries
        $this->_reverseBillLedger($id, $companyId);

        if ($Bills->delete($bill)) {
            $this->Flash->success(__('Bill deleted.'));
        } else {
            $this->Flash->error(__('Could not delete bill.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function _postBillToLedger($bill, int $companyId): void
    {
        if (!isset($bill->bill_items) || empty($bill->bill_items)) {
            $bill = $this->fetchTable('Bills')->get($bill->id, contain: ['BillItems']);
        }

        $Transactions = $this->fetchTable('Transactions');
        $Accounts     = $this->fetchTable('Accounts');
        $Rates        = $this->fetchTable('ExchangeRates');

        // Fetch current exchange rate for ZWG conversion
        $rate = $Rates->find()
            ->where(['company_id' => $companyId, 'currency' => $bill->currency])
            ->where(['date <=' => $bill->date ?: date('Y-m-d')])
            ->orderBy(['date' => 'DESC'])
            ->first();
        $rateVal = $rate ? (float)$rate->rate_to_base : 1.0;

        // Accounts Payable Account
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

        // Ensure "VAT Input" asset account exists
        $vatInputAccount = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.name LIKE' => '%VAT Input%'])
            ->first();

        if (!$vatInputAccount) {
            $vatInputAccount = $Accounts->newEntity([
                'name' => 'VAT Input',
                'category' => 'Taxes Receivable',
                'type' => 'Asset',
                'company_id' => $companyId
            ]);
            $Accounts->save($vatInputAccount);
        }
        $vatInputAccountId = $vatInputAccount->id;

        $date     = $bill->date ? $bill->date->format('Y-m-d') : date('Y-m-d');
        $ref      = $bill->reference ?? "BILL-{$bill->id}";
        $currency = $bill->currency ?? 'USD';
        $total    = (float)($bill->total ?? 0);
        $groupId  = Text::uuid();

        $Transactions->getConnection()->transactional(function () use (
            $Transactions, $bill, $apAccount, $vatInputAccountId, $date, $ref, $currency, $total, $groupId, $companyId, $rateVal
        ) {
            // Credit: Accounts Payable (Full Amount)
            $cr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Bill $ref",
                'currency'          => $currency,
                'amount'            => $total,
                'zwg'               => $total * $rateVal,
                'type'              => 'Credit',
                'account_id'        => $apAccount->id,
                'supplier_id'       => $bill->supplier_id,
                'tenant_id'         => !empty($bill->tenant_id) ? $bill->tenant_id : null,
                'bill_id'           => $bill->id,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($cr, ['check_balance' => false]);

            if (!empty($bill->bill_items)) {
                $totalVat = 0.0;
                foreach ($bill->bill_items as $item) {
                    $qty        = (float)($item->quantity ?? 1);
                    $price      = (float)($item->unit_price ?? 0);
                    $vatRate    = (float)($item->vat_rate ?? 0);
                    
                    // Priority: 1. Stored vat_amount, 2. Calculation from vat_rate
                    $itemVat    = (float)($item->vat_amount ?? ($qty * $price * ($vatRate / 100)));
                    
                    // Priority: 1. Stored line_total (Gross), 2. Calculation (Qty * Price) + VAT
                    $itemGross  = (float)($item->line_total ?: ($qty * $price) + $itemVat);
                    
                    $netAmount  = $itemGross - $itemVat;
                    $totalVat  += $itemVat;

                    if (!$item->account_id || $netAmount == 0) continue;

                    // Debit: Expense Account (Net)
                    $dr = $Transactions->newEntity([
                        'company_id'        => $companyId,
                        'date'              => $date,
                        'description'       => "Bill $ref — " . ($item->description ?? ''),
                        'currency'          => $currency,
                        'amount'            => $netAmount,
                        'zwg'               => $netAmount * $rateVal,
                        'type'              => 'Debit',
                        'account_id'        => $item->account_id,
                        'supplier_id'       => $bill->supplier_id,
                        'tenant_id'         => !empty($bill->tenant_id) ? $bill->tenant_id : null,
                        'bill_id'           => $bill->id,
                        'transaction_group' => $groupId,
                    ], ['validate' => false]);
                    $Transactions->save($dr, ['check_balance' => false]);
                }

                // Debit: VAT Input Account (Total VAT)
                if ($totalVat > 0) {
                    $drVat = $Transactions->newEntity([
                        'company_id'        => $companyId,
                        'date'              => $date,
                        'description'       => "VAT Input — Bill $ref",
                        'currency'          => $currency,
                        'amount'            => $totalVat,
                        'zwg'               => $totalVat * $rateVal,
                        'type'              => 'Debit',
                        'account_id'        => $vatInputAccountId,
                        'supplier_id'       => $bill->supplier_id,
                        'tenant_id'         => !empty($bill->tenant_id) ? $bill->tenant_id : null,
                        'bill_id'           => $bill->id,
                        'transaction_group' => $groupId,
                    ], ['validate' => false]);
                    $Transactions->save($drVat, ['check_balance' => false]);
                }
            }
        });
    }

    private function _reverseBillLedger(int $billId, int $companyId): void
    {
        $Transactions = $this->fetchTable('Transactions');
        $groups = $Transactions->find()
            ->where(['Transactions.bill_id' => $billId, 'Transactions.company_id' => $companyId])
            ->select(['transaction_group'])
            ->distinct(['transaction_group'])
            ->all()->extract('transaction_group')->filter()->toArray();

        if (!empty($groups)) {
            $Transactions->deleteAll(['transaction_group IN' => $groups, 'company_id' => $companyId]);
        }
    }

    /**
     * Helper to send bill email
     */
    private function _sendBillEmail(int $id): void
    {
        try {
            $bill = $this->fetchTable('Bills')->get($id, contain: ['Suppliers' => ['Contacts']]);
            $email = $bill->supplier->contact->email ?? null;

            if ($email) {
                $this->getMailer('Notification')->send('bill', [$bill->toArray(), $email]);
            }
        } catch (\Exception $e) {
            $this->Flash->warning(__('Bill saved, but email could not be sent: ' . $e->getMessage()));
        }
    }
}
