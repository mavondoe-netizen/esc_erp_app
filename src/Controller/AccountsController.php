<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Accounts Controller
 *
 * Chart of Accounts — CRUD plus an import helper and the opening-balance
 * management screen.
 */
class AccountsController extends AppController
{
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Accounts = $this->fetchTable('Accounts');

        $conditions = ['Accounts.company_id' => $companyId];

        $filterType = $this->request->getQuery('type');
        if ($filterType) $conditions['Accounts.type'] = $filterType;

        $query = $Accounts->find()
            ->where($conditions)
            ->order(['Accounts.type', 'Accounts.category', 'Accounts.name']);

        $accounts = $this->paginate($query, ['limit' => 100]);

        // Summary totals for the sidebar
        $typeTotals = $Accounts->find()
            ->select(['type', 'total' => $Accounts->find()->func()->count('*')])
            ->where(['Accounts.company_id' => $companyId])
            ->groupBy('type')
            ->all()
            ->combine('type', fn($r) => $r->total)
            ->toArray();

        $this->set(compact('accounts', 'typeTotals'));
    }

    public function view(int $id)
    {
        $companyId = $this->request->getAttribute('company_id');

        $Accounts = $this->fetchTable('Accounts');
        $account  = $Accounts->get($id, contain: ['Transactions' => function ($q) {
            return $q->order(['Transactions.date' => 'DESC'])->limit(50);
        }]);

        $this->set(compact('account'));
    }

    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Accounts = $this->fetchTable('Accounts');
        $account  = $Accounts->newEmptyEntity();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['company_id'] = $companyId;
            $account = $Accounts->patchEntity($account, $data);

            if ($this->request->getQuery('popup')) {
                if ($Accounts->save($account)) {
                    $this->set('popupResult', ['id' => $account->id, 'name' => $account->name]);
                    $this->viewBuilder()->disableAutoLayout();
                    return $this->render('/Element/popup_success');
                }
            }

            if ($Accounts->save($account)) {
                $this->Flash->success(__('Account saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not save account. Check for errors.'));
        }

        $types = [
            'Asset' => 'Asset',
            'Liability' => 'Liability',
            'Equity' => 'Equity',
            'Income' => 'Income',
            'Expense' => 'Expense',
            'Revenue' => 'Revenue'
        ];
        $categories = [
            'Current Asset' => 'Current Asset',
            'Fixed Asset' => 'Fixed Asset',
            'Current Liability' => 'Current Liability',
            'Long-term Liability' => 'Long-term Liability',
            'Owner\'s Equity' => 'Owner\'s Equity',
            'Operating Revenue' => 'Operating Revenue',
            'Other Income' => 'Other Income',
            'Operating Expense' => 'Operating Expense',
            'Other Expense' => 'Other Expense'
        ];
        $subcategories = [
            'Cash and Cash Equivalents' => 'Cash and Cash Equivalents',
            'Accounts Receivable' => 'Accounts Receivable',
            'Inventory' => 'Inventory',
            'Property, Plant and Equipment' => 'Property, Plant and Equipment',
            'Intangible Assets' => 'Intangible Assets',
            'Accounts Payable' => 'Accounts Payable',
            'Accrued Expenses' => 'Accrued Expenses',
            'Sales' => 'Sales',
            'Cost of Goods Sold' => 'Cost of Goods Sold',
            'Salaries and Wages' => 'Salaries and Wages',
            'Rent' => 'Rent',
            'Utilities' => 'Utilities',
            'Other' => 'Other'
        ];
        $this->set(compact('account', 'types', 'categories', 'subcategories'));
    }

    public function edit(int $id)
    {
        $companyId = $this->request->getAttribute('company_id');

        $Accounts = $this->fetchTable('Accounts');
        $account  = $Accounts->get($id);

        if ($this->request->is(['post', 'put'])) {
            $account = $Accounts->patchEntity($account, $this->request->getData());
            if ($Accounts->save($account)) {
                $this->Flash->success(__('Account updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not update account.'));
        }

        $types = [
            'Asset' => 'Asset',
            'Liability' => 'Liability',
            'Equity' => 'Equity',
            'Income' => 'Income',
            'Expense' => 'Expense',
            'Revenue' => 'Revenue'
        ];
        $categories = [
            'Current Asset' => 'Current Asset',
            'Fixed Asset' => 'Fixed Asset',
            'Current Liability' => 'Current Liability',
            'Long-term Liability' => 'Long-term Liability',
            'Owner\'s Equity' => 'Owner\'s Equity',
            'Operating Revenue' => 'Operating Revenue',
            'Other Income' => 'Other Income',
            'Operating Expense' => 'Operating Expense',
            'Other Expense' => 'Other Expense'
        ];
        $subcategories = [
            'Cash and Cash Equivalents' => 'Cash and Cash Equivalents',
            'Accounts Receivable' => 'Accounts Receivable',
            'Inventory' => 'Inventory',
            'Property, Plant and Equipment' => 'Property, Plant and Equipment',
            'Intangible Assets' => 'Intangible Assets',
            'Accounts Payable' => 'Accounts Payable',
            'Accrued Expenses' => 'Accrued Expenses',
            'Sales' => 'Sales',
            'Cost of Goods Sold' => 'Cost of Goods Sold',
            'Salaries and Wages' => 'Salaries and Wages',
            'Rent' => 'Rent',
            'Utilities' => 'Utilities',
            'Other' => 'Other'
        ];
        $this->set(compact('account', 'types', 'categories', 'subcategories'));
    }

    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyId = $this->request->getAttribute('company_id');

        $Accounts = $this->fetchTable('Accounts');
        $account  = $Accounts->find()
            ->where(['Accounts.id' => $id, 'Accounts.company_id' => $companyId])
            ->first();

        if ($account && $Accounts->delete($account)) {
            $this->Flash->success(__('Account deleted.'));
        } else {
            $this->Flash->error(__('Could not delete account. It may have associated transactions.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Opening Balances management screen.
     * Displays all accounts with their current opening_balance for batch editing.
     *
     * @return \Cake\Http\Response|null
     */
    public function openingBalances()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Accounts = $this->fetchTable('Accounts');

        if ($this->request->is('post')) {
            $rows = (array)$this->request->getData('balances', []);
            $errors = [];

            foreach ($rows as $accountId => $balance) {
                $acc = $Accounts->find()
                    ->where(['Accounts.id' => (int)$accountId, 'Accounts.company_id' => $companyId])
                    ->first();
                if (!$acc) continue;

                $acc->opening_balance = (float)str_replace(',', '', $balance);
                if (!$Accounts->save($acc, ['validate' => false])) {
                    $errors[] = "Could not save '{$acc->name}'.";
                }
            }

            if (empty($errors)) {
                $this->Flash->success('Opening balances updated.');
            } else {
                $this->Flash->error(implode('<br>', $errors));
            }

            return $this->redirect(['action' => 'openingBalances']);
        }

        $accounts = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId])
            ->order(['Accounts.type', 'Accounts.category', 'Accounts.name'])
            ->all();

        $sumOfBalances = $accounts->sumOf('opening_balance');
        $this->set(compact('accounts', 'sumOfBalances'));
    }
}
