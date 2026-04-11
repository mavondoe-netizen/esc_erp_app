<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Transactions Controller
 *
 * @property \App\Model\Table\TransactionsTable $Transactions
 */
class TransactionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Accounting');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $conditions = [];
        $accountId = $this->request->getQuery('account_id');
        $categoryId = $this->request->getQuery('category');
        $startDate = $this->request->getQuery('start_date');
        $endDate = $this->request->getQuery('end_date');
        $search = $this->request->getQuery('search');
        
        if ($accountId) {
            $conditions['Transactions.account_id'] = $accountId;
        }
        if ($categoryId) {
            $conditions['Accounts.category'] = $categoryId;
        }
        if ($startDate) {
            $conditions['Transactions.date >='] = $startDate;
        }
        if ($endDate) {
            $conditions['Transactions.date <='] = $endDate;
        }
        if ($search) {
            $conditions['Transactions.description LIKE'] = '%' . $search . '%';
        }

        $query = $this->fetchTable('Transactions')->find()
            ->contain(['Accounts', 'Buildings', 'Tenants', 'Suppliers', 'Customers'])
            ->where($conditions);
            
        $transactions = $this->paginate($query);

        $accounts = $this->fetchTable('Accounts')->find('list')->all();
        $categories = [
            'Asset' => 'Asset',
            'Liability' => 'Liability',
            'Equity' => 'Equity',
            'Revenue' => 'Revenue',
            'Expense' => 'Expense'
        ];

        $this->set(compact('transactions', 'accounts', 'categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaction = $this->fetchTable('Transactions')->get($id, contain: ['Accounts', 'Buildings', 'Tenants', 'Suppliers', 'Customers', 'Bills', 'Invoices', 'Receipts']);
        $this->set(compact('transaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transaction = $this->fetchTable('Transactions')->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $transaction = $this->fetchTable('Transactions')->patchEntity($transaction, $data);
            if ($this->fetchTable('Transactions')->save($transaction)) {
                // Exchange Gain/Loss Logic
                $company_id = $this->request->getAttribute('identity')->company_id;
                
                if (!empty($data['invoice_id'])) {
                    $rate = $this->Accounting->getCurrentRate($company_id, $transaction->currency, $transaction->date);
                    $this->Accounting->recordExchangeVariance($company_id, 'invoice', (int)$data['invoice_id'], (float)$transaction->amount, $rate, $transaction->date);
                } elseif (!empty($data['bill_id'])) {
                    $rate = $this->Accounting->getCurrentRate($company_id, $transaction->currency, $transaction->date);
                    $this->Accounting->recordExchangeVariance($company_id, 'bill', (int)$data['bill_id'], (float)$transaction->amount, $rate, $transaction->date);
                }

                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $accounts = $this->fetchTable('Transactions')->Accounts->find('list', limit: 200)->all();
        $buildings = $this->fetchTable('Transactions')->Buildings->find('list', limit: 200)->all();
        $tenants = $this->fetchTable('Transactions')->Tenants->find('list', limit: 200)->all();
        $suppliers = $this->fetchTable('Transactions')->Suppliers->find('list', limit: 200)->all();
        $customers = $this->fetchTable('Transactions')->Customers->find('list', limit: 200)->all();
        $bills = $this->fetchTable('Transactions')->Bills->find('list', limit: 200)->all();
        $invoices = $this->fetchTable('Transactions')->Invoices->find('list', limit: 200)->all();
        $receipts = $this->fetchTable('Transactions')->Receipts->find('list', limit: 200)->all();
        $departments = $this->fetchTable('Departments')->find('list')->all();
        $bankTransactions = $this->fetchTable('Transactions')->BankTransactions->find('list')->all();
        $this->set(compact('transaction', 'accounts', 'buildings', 'tenants', 'suppliers', 'customers', 'bills', 'invoices', 'receipts', 'departments', 'bankTransactions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaction = $this->fetchTable('Transactions')->get($id, contain: ['Bills', 'Invoices', 'Receipts']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->fetchTable('Transactions')->patchEntity($transaction, $this->request->getData());
            if ($this->fetchTable('Transactions')->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $accounts = $this->fetchTable('Transactions')->Accounts->find('list', limit: 200)->all();
        $buildings = $this->fetchTable('Transactions')->Buildings->find('list', limit: 200)->all();
        $tenants = $this->fetchTable('Transactions')->Tenants->find('list', limit: 200)->all();
        $suppliers = $this->fetchTable('Transactions')->Suppliers->find('list', limit: 200)->all();
        $customers = $this->fetchTable('Transactions')->Customers->find('list', limit: 200)->all();
        $bills = $this->fetchTable('Transactions')->Bills->find('list', limit: 200)->all();
        $invoices = $this->fetchTable('Transactions')->Invoices->find('list', limit: 200)->all();
        $receipts = $this->fetchTable('Transactions')->Receipts->find('list', limit: 200)->all();
        $departments = $this->fetchTable('Departments')->find('list')->all();
        $bankTransactions = $this->fetchTable('Transactions')->BankTransactions->find('list')->all();
        $this->set(compact('transaction', 'accounts', 'buildings', 'tenants', 'suppliers', 'customers', 'bills', 'invoices', 'receipts', 'departments', 'bankTransactions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transaction = $this->fetchTable('Transactions')->get($id);
        if ($this->fetchTable('Transactions')->delete($transaction)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Bulk Journal Entry — post multiple ledger lines in a single form submission.
     *
     * GET  /transactions/bulk-add  — renders the form
     * POST /transactions/bulk-add  — saves all submitted rows
     */
    public function bulkAdd()
    {
        $table = $this->fetchTable('Transactions');
        $accounts    = $table->Accounts->find('list', ['limit' => 500])->all();
        $customers   = $table->Customers->find('list', ['limit' => 500])->all();
        $suppliers   = $table->Suppliers->find('list', ['limit' => 500])->all();
        $departments = $this->fetchTable('Departments')->find('list')->all();
        $companyId   = \Cake\Core\Configure::read('Tenant.company_id');

        if ($this->request->is('post')) {
            $rows = $this->request->getData('rows', []);

            if (empty($rows)) {
                $this->Flash->error(__('No journal lines were submitted.'));
                $this->set(compact('accounts', 'customers', 'suppliers', 'departments'));
                return;
            }

            // ── Pass 1: Build & validate all entities without saving ────────────
            $entities = [];
            $errors   = [];

            foreach ($rows as $i => $row) {
                // Skip completely empty rows
                if (empty($row['description']) && empty($row['amount'])) {
                    continue;
                }

                $row['company_id'] = $companyId;
                $entity = $table->newEntity($row);

                if ($entity->getErrors()) {
                    foreach ($entity->getErrors() as $field => $msgs) {
                        $errors[] = "Row " . ($i + 1) . " [{$field}]: " . implode(', ', $msgs);
                    }
                } else {
                    $entities[] = $entity;
                }
            }

            if (!empty($errors)) {
                $this->Flash->error(__("Validation failed — no changes saved. Errors: " . implode(' | ', $errors)));
                $this->set(compact('accounts', 'customers', 'suppliers', 'departments'));
                return;
            }

            if (empty($entities)) {
                $this->Flash->error(__('No valid journal lines to post.'));
                $this->set(compact('accounts', 'customers', 'suppliers', 'departments'));
                return;
            }

            // ── Pass 1.5: Verify the batch total balances to zero ───────────────
            $totalZwg = 0;
            $groupId = \Cake\Utility\Text::uuid();
            foreach ($entities as $entity) {
                $isDebit = in_array(strtolower(trim((string)$entity->type)), ['2', 'debit']);
                $totalZwg += ($isDebit ? (float)$entity->zwg : -(float)$entity->zwg);
                $entity->transaction_group = $groupId;
            }

            if (abs($totalZwg) > 0.001) {
                $this->Flash->error(__("The journal entry is unbalanced (Net: {0}). Total Debits must equal Total Credits.", $totalZwg));
                $this->set(compact('accounts', 'customers', 'suppliers', 'departments'));
                return;
            }

            // ── Pass 2: Save all validated entities atomically ──────────────────
            // We pass check_balance => false because we've already validated the whole batch. 
            // Sequential saves would otherwise fail.
            if ($table->saveMany($entities, ['check_balance' => false])) {
                $this->Flash->success(__("Successfully posted balanced journal with {0} lines.", count($entities)));
                return $this->redirect(['action' => 'index']);
            } else {
                // Collect per-entity errors for feedback
                $saveErrors = [];
                foreach ($entities as $idx => $ent) {
                    foreach ($ent->getErrors() as $field => $msgs) {
                        $saveErrors[] = "Row " . ($idx + 1) . " [{$field}]: " . implode(', ', $msgs);
                    }
                }
                $this->Flash->error(__("Save failed. " . (!empty($saveErrors) ? implode(' | ', $saveErrors) : 'Please check data format.')));
            }
        }

        $this->set(compact('accounts', 'customers', 'suppliers', 'departments'));
    }

}
