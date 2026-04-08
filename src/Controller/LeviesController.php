<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Levies Controller — Manages tenant levies and posts expenses when paid.
 */
class LeviesController extends AppController
{
    public function index()
    {
        $query = $this->fetchTable('Levies')->find()
            ->contain(['Tenants', 'Units', 'Buildings'])
            ->order(['due_date' => 'ASC', 'paid' => 'ASC']);
        $levies = $this->paginate($query);
        $this->set(compact('levies'));
    }

    public function view($id = null)
    {
        $levy = $this->fetchTable('Levies')->get($id, contain: ['Tenants', 'Units', 'Buildings', 'Accounts']);
        $this->set(compact('levy'));
    }

    public function add()
    {
        $levy = $this->fetchTable('Levies')->newEmptyEntity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $levy->company_id = $companyId;
        $levy->currency = 'USD';
        $levy->paid = false;
        $levy->due_date = date('Y-m-d');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['company_id'] = $companyId;
            $levy = $this->fetchTable('Levies')->patchEntity($levy, $data);

            if ($this->fetchTable('Levies')->save($levy)) {
                $this->Flash->success(__('Levy created successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not save levy. Please try again.'));
        }

        $tenants   = $this->fetchTable('Tenants')->find('list')->all();
        $units     = $this->fetchTable('Units')->find('list')->all();
        $buildings = $this->fetchTable('Buildings')->find('list')->all();
        $accounts  = $this->fetchTable('Accounts')->find('list', ['conditions' => ['category IN' => ['Asset', 'Bank']]])->all();
        $levyTypes = ['Maintenance' => 'Maintenance', 'Refuse' => 'Refuse', 'Water' => 'Water', 'Security' => 'Security', 'RATS' => 'RATS', 'Garden' => 'Garden', 'Other' => 'Other'];
        $currencies = ['USD' => 'USD', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR'];

        $this->set(compact('levy', 'tenants', 'units', 'buildings', 'accounts', 'levyTypes', 'currencies'));
    }

    public function edit($id = null)
    {
        $levy = $this->fetchTable('Levies')->get($id, contain: []);
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['company_id'] = $companyId;
            $levy = $this->fetchTable('Levies')->patchEntity($levy, $data);

            if ($this->fetchTable('Levies')->save($levy)) {
                $this->Flash->success(__('Levy updated successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not update levy.'));
        }

        $tenants   = $this->fetchTable('Tenants')->find('list')->all();
        $units     = $this->fetchTable('Units')->find('list')->all();
        $buildings = $this->fetchTable('Buildings')->find('list')->all();
        $accounts  = $this->fetchTable('Accounts')->find('list', ['conditions' => ['category IN' => ['Asset', 'Bank']]])->all();
        $levyTypes = ['Maintenance' => 'Maintenance', 'Refuse' => 'Refuse', 'Water' => 'Water', 'Security' => 'Security', 'RATS' => 'RATS', 'Garden' => 'Garden', 'Other' => 'Other'];
        $currencies = ['USD' => 'USD', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR'];

        $this->set(compact('levy', 'tenants', 'units', 'buildings', 'accounts', 'levyTypes', 'currencies'));
    }

    /**
     * Mark a levy as paid and post operating expense + bank debit to ledger.
     */
    public function markPaid($id = null)
    {
        $this->request->allowMethod(['post']);
        $levy = $this->fetchTable('Levies')->get($id, contain: ['Tenants']);
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');

        if ($levy->paid) {
            $this->Flash->error(__('This levy has already been marked as paid.'));
            return $this->redirect(['action' => 'index']);
        }

        $levy->paid = true;
        $levy->paid_date = date('Y-m-d');
        $data = $this->request->getData();
        if (!empty($data['account_id'])) {
            $levy->account_id = (int)$data['account_id'];
        }

        if ($this->fetchTable('Levies')->save($levy)) {
            // --- DOUBLE-ENTRY: Operating Expense + Bank Credit ---
            $txTable = $this->fetchTable('Transactions');
            $txGroup = Text::uuid();
            $amount   = (float)$levy->amount;
            $currency = $levy->currency ?? 'USD';
            $desc     = 'Levy ' . $levy->levy_type . ' – ' . ($levy->hasValue('tenant') ? $levy->tenant->name : 'Tenant #' . $levy->tenant_id);

            // Find or create Maintenance Expenses account by name lookup
            $expenseAccount = $this->fetchTable('Accounts')->find()
                ->where(['name LIKE' => '%Maintenance%', 'category' => 'Expense'])
                ->first();
            if (!$expenseAccount) {
                // Fall back to any Operating Expense
                $expenseAccount = $this->fetchTable('Accounts')->find()
                    ->where(['subcategory LIKE' => '%Operating%', 'category' => 'Expense'])
                    ->first();
            }
            $expenseAccountId = $expenseAccount ? $expenseAccount->id : null;
            $bankAccountId = $levy->account_id;

            if ($bankAccountId && $expenseAccountId) {
                // Debit Maintenance Expense (increases)
                $txTable->save($txTable->newEntity([
                    'date'              => $levy->paid_date,
                    'description'       => $desc,
                    'amount'            => $amount,
                    'zwg'               => $amount,
                    'currency'          => $currency,
                    'account_id'        => $expenseAccountId,
                    'company_id'        => $companyId,
                    'tenant_id'         => $levy->tenant_id,
                    'building_id'       => $levy->building_id,
                    'type'              => '2', // Debit
                    'transaction_group' => $txGroup,
                ]));
                // Credit Bank (asset decreases on payout)
                $txTable->save($txTable->newEntity([
                    'date'              => $levy->paid_date,
                    'description'       => $desc,
                    'amount'            => $amount,
                    'zwg'               => $amount,
                    'currency'          => $currency,
                    'account_id'        => $bankAccountId,
                    'company_id'        => $companyId,
                    'tenant_id'         => $levy->tenant_id,
                    'building_id'       => $levy->building_id,
                    'type'              => '1', // Credit
                    'transaction_group' => $txGroup,
                ]));
            }

            $this->Flash->success(__('Levy marked as paid and posted to operating expenses.'));
        } else {
            $this->Flash->error(__('Could not update levy status.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $levy = $this->fetchTable('Levies')->get($id);
        if ($this->fetchTable('Levies')->delete($levy)) {
            $this->Flash->success(__('Levy deleted.'));
        } else {
            $this->Flash->error(__('Could not delete levy.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
