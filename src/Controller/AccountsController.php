<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Accounts Controller
 *
 * @property \App\Model\Table\AccountsTable $Accounts
 */
class AccountsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Accounts')->find();
        $accounts = $this->paginate($query);

        $this->set(compact('accounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $account = $this->fetchTable('Accounts')->get($id, contain: ['Invoices',  'BillItems', 'InvoiceItems', 'Receipts', 'Transactions']);
        $this->set(compact('account'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $account = $this->fetchTable('Accounts')->newEmptyEntity();
        if ($this->request->is('post')) {
            $account = $this->fetchTable('Accounts')->patchEntity($account, $this->request->getData());
            if ($this->fetchTable('Accounts')->save($account)) {
                $this->Flash->success(__('The account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The account could not be saved. Please, try again.'));
        }
        $categories = [
            'Asset' => 'Asset',
            'Liability' => 'Liability',
            'Equity' => 'Equity',
            'Revenue' => 'Revenue',
            'Expense' => 'Expense'
        ];
        $types = [
            'Current Asset' => 'Current Asset',
            'Fixed Asset' => 'Fixed Asset',
            'Non-current Asset' => 'Non-current Asset',
            'Current Liability' => 'Current Liability',
            'Non-current Liability' => 'Non-current Liability',
            'Equity' => 'Equity',
            'Operating Revenue' => 'Operating Revenue',
            'Non-operating Revenue' => 'Non-operating Revenue',
            'Operating Expense' => 'Operating Expense',
            'Non-operating Expense' => 'Non-operating Expense'
        ];
        $subcategories = [
            'Cash and Bank' => 'Cash and Bank',
            'Accounts Receivable' => 'Accounts Receivable',
            'Inventory' => 'Inventory',
            'Fixed Assets' => 'Fixed Assets',
            'Accounts Payable' => 'Accounts Payable',
            'Credit Cards' => 'Credit Cards',
            'Long-term Liabilities' => 'Long-term Liabilities',
            'Owner\'s Equity' => 'Owner\'s Equity',
            'Sales' => 'Sales',
            'Cost of Goods Sold' => 'Cost of Goods Sold',
            'Operating Expenses' => 'Operating Expenses',
            'Payroll Expenses' => 'Payroll Expenses',
            'Other' => 'Other'
        ];
        $this->set(compact('account', 'categories', 'types', 'subcategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $account = $this->fetchTable('Accounts')->get($id, contain: ['Invoices']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $account = $this->fetchTable('Accounts')->patchEntity($account, $this->request->getData());
            if ($this->fetchTable('Accounts')->save($account)) {
                $this->Flash->success(__('The account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The account could not be saved. Please, try again.'));
        }
        $categories = [
            'Asset' => 'Asset',
            'Liability' => 'Liability',
            'Equity' => 'Equity',
            'Revenue' => 'Revenue',
            'Expense' => 'Expense'
        ];
        $types = [
            'Current Asset' => 'Current Asset',
            'Fixed Asset' => 'Fixed Asset',
            'Non-current Asset' => 'Non-current Asset',
            'Current Liability' => 'Current Liability',
            'Non-current Liability' => 'Non-current Liability',
            'Equity' => 'Equity',
            'Operating Revenue' => 'Operating Revenue',
            'Non-operating Revenue' => 'Non-operating Revenue',
            'Operating Expense' => 'Operating Expense',
            'Non-operating Expense' => 'Non-operating Expense'
        ];
        $subcategories = [
            'Cash and Bank' => 'Cash and Bank',
            'Accounts Receivable' => 'Accounts Receivable',
            'Inventory' => 'Inventory',
            'Fixed Assets' => 'Fixed Assets',
            'Accounts Payable' => 'Accounts Payable',
            'Credit Cards' => 'Credit Cards',
            'Long-term Liabilities' => 'Long-term Liabilities',
            'Owner\'s Equity' => 'Owner\'s Equity',
            'Sales' => 'Sales',
            'Cost of Goods Sold' => 'Cost of Goods Sold',
            'Operating Expenses' => 'Operating Expenses',
            'Payroll Expenses' => 'Payroll Expenses',
            'Other' => 'Other'
        ];
        $this->set(compact('account', 'categories', 'types', 'subcategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $account = $this->fetchTable('Accounts')->get($id);
        if ($this->fetchTable('Accounts')->delete($account)) {
            $this->Flash->success(__('The account has been deleted.'));
        } else {
            $this->Flash->error(__('The account could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
