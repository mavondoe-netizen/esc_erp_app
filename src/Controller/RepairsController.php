<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Repairs Controller — Tracks unit maintenance and posts costs to the ledger on completion.
 */
class RepairsController extends AppController
{
    public function index()
    {
        $query = $this->fetchTable('Repairs')->find()
            ->contain(['Units', 'Buildings', 'Tenants'])
            ->order(['status' => 'ASC', 'reported_date' => 'DESC']);
        $repairs = $this->paginate($query);
        $this->set(compact('repairs'));
    }

    public function view($id = null)
    {
        $repair = $this->fetchTable('Repairs')->get($id, contain: ['Units', 'Buildings', 'Tenants', 'Accounts']);
        $this->set(compact('repair'));
    }

    public function add()
    {
        $repair = $this->fetchTable('Repairs')->newEmptyEntity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $repair->company_id = $companyId;
        $repair->status = 'Reported';
        $repair->reported_date = date('Y-m-d');
        $repair->currency = 'USD';

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['company_id'] = $companyId;
            $repair = $this->fetchTable('Repairs')->patchEntity($repair, $data);

            if ($this->fetchTable('Repairs')->save($repair)) {
                $this->Flash->success(__('Repair request logged successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not log repair. Please try again.'));
        }

        $units     = $this->fetchTable('Units')->find('list')->all();
        $buildings = $this->fetchTable('Buildings')->find('list')->all();
        $tenants   = $this->fetchTable('Tenants')->find('list')->all();
        $accounts  = $this->fetchTable('Accounts')->find('list', ['conditions' => ['category' => 'Expense']])->all();
        $statuses   = ['Reported' => 'Reported', 'In Progress' => 'In Progress', 'Completed' => 'Completed', 'Cancelled' => 'Cancelled'];
        $categories = ['Plumbing' => 'Plumbing', 'Electrical' => 'Electrical', 'Structural' => 'Structural', 'Painting' => 'Painting', 'Carpentry' => 'Carpentry', 'General' => 'General'];
        $currencies = ['USD' => 'USD', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR'];

        $this->set(compact('repair', 'units', 'buildings', 'tenants', 'accounts', 'statuses', 'categories', 'currencies'));
    }

    public function edit($id = null)
    {
        $repair = $this->fetchTable('Repairs')->get($id, contain: []);
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $wasCompleted = $repair->status === 'Completed';
            $repair = $this->fetchTable('Repairs')->patchEntity($repair, $data);

            if ($this->fetchTable('Repairs')->save($repair)) {
                // Auto-post to ledger when newly marked Completed with a cost
                if (!$wasCompleted && $repair->status === 'Completed' && $repair->cost > 0) {
                    $this->_postRepairCost($repair, $companyId);
                }
                $this->Flash->success(__('Repair updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not update repair.'));
        }

        $units     = $this->fetchTable('Units')->find('list')->all();
        $buildings = $this->fetchTable('Buildings')->find('list')->all();
        $tenants   = $this->fetchTable('Tenants')->find('list')->all();
        $accounts  = $this->fetchTable('Accounts')->find('list', ['conditions' => ['category' => 'Expense']])->all();
        $statuses   = ['Reported' => 'Reported', 'In Progress' => 'In Progress', 'Completed' => 'Completed', 'Cancelled' => 'Cancelled'];
        $categories = ['Plumbing' => 'Plumbing', 'Electrical' => 'Electrical', 'Structural' => 'Structural', 'Painting' => 'Painting', 'Carpentry' => 'Carpentry', 'General' => 'General'];
        $currencies = ['USD' => 'USD', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR'];

        $this->set(compact('repair', 'units', 'buildings', 'tenants', 'accounts', 'statuses', 'categories', 'currencies'));
    }

    /**
     * Posts repair cost to the ledger:
     * Debit Maintenance Expense / Credit Accounts Payable
     */
    protected function _postRepairCost($repair, $companyId): void
    {
        $txTable  = $this->fetchTable('Transactions');
        $txGroup  = Text::uuid();
        $amount   = (float)$repair->cost;
        $currency = $repair->currency ?? 'USD';
        $date     = $repair->resolved_date ?? date('Y-m-d');
        $desc     = 'Repair: ' . $repair->title;

        // Determine maintenance expense account
        $expenseAccountId = $repair->account_id;
        if (!$expenseAccountId) {
            $acct = $this->fetchTable('Accounts')->find()
                ->where(['name LIKE' => '%Maintenance%', 'category' => 'Expense'])
                ->first();
            $expenseAccountId = $acct ? $acct->id : null;
        }

        // Find Accounts Payable for the offset credit
        $apAccount = $this->fetchTable('Accounts')->find()
            ->where(['name LIKE' => '%Payable%', 'category' => 'Liability'])
            ->first();
        $apAccountId = $apAccount ? $apAccount->id : null;

        if ($expenseAccountId && $apAccountId) {
            $txTable->save($txTable->newEntity([
                'date'              => $date,
                'description'       => $desc,
                'amount'            => $amount,
                'zwg'               => $amount,
                'currency'          => $currency,
                'account_id'        => $expenseAccountId,
                'company_id'        => $companyId,
                'building_id'       => $repair->building_id,
                'type'              => '2', // Debit maintenance expense
                'transaction_group' => $txGroup,
            ]));
            $txTable->save($txTable->newEntity([
                'date'              => $date,
                'description'       => $desc,
                'amount'            => $amount,
                'zwg'               => $amount,
                'currency'          => $currency,
                'account_id'        => $apAccountId,
                'company_id'        => $companyId,
                'building_id'       => $repair->building_id,
                'type'              => '1', // Credit Accounts Payable
                'transaction_group' => $txGroup,
            ]));
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $repair = $this->fetchTable('Repairs')->get($id);
        if ($this->fetchTable('Repairs')->delete($repair)) {
            $this->Flash->success(__('Repair deleted.'));
        } else {
            $this->Flash->error(__('Could not delete repair.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
