<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Transactions Controller
 *
 * General ledger journal entries. Handles standard CRUD, bulk journal add/edit,
 * and the AJAX bulk-delete action.
 */
class TransactionsController extends AppController
{
    // -----------------------------------------------------------------------
    // INDEX — paginated list with filters
    // -----------------------------------------------------------------------

    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Transactions = $this->fetchTable('Transactions');
        $Accounts     = $this->fetchTable('Accounts');

        // Filters
        $startDate  = $this->request->getQuery('start_date');
        $endDate    = $this->request->getQuery('end_date');
        $accountId  = $this->request->getQuery('account_id');
        $category   = $this->request->getQuery('category');
        $search     = $this->request->getQuery('search');

        $conditions = ['Transactions.company_id' => $companyId];

        if ($startDate) $conditions['Transactions.date >='] = $startDate;
        if ($endDate)   $conditions['Transactions.date <='] = $endDate;
        if ($accountId) $conditions['Transactions.account_id'] = (int)$accountId;
        if ($search)    $conditions['Transactions.description LIKE'] = '%' . $search . '%';

        if ($category) {
            $accountIds = $Accounts->find()
                ->where(['Accounts.company_id' => $companyId, 'Accounts.category' => $category])
                ->select(['id'])
                ->all()
                ->extract('id')
                ->toArray();
            $conditions['Transactions.account_id IN'] = $accountIds ?: [0];
        }

        $query = $Transactions->find()
            ->where($conditions)
            ->contain(['Accounts', 'Departments', 'Buildings', 'Tenants', 'Suppliers', 'Customers'])
            ->order(['Transactions.date' => 'DESC', 'Transactions.id' => 'DESC']);

        $transactions = $this->paginate($query, ['limit' => 50]);

        // Dropdown data
        $accounts = $Accounts->find('list', keyField: 'id', valueField: 'name')
            ->where(['Accounts.company_id' => $companyId])
            ->order(['Accounts.type', 'Accounts.name'])
            ->all();

        $categories = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId])
            ->select(['category'])
            ->distinct(['category'])
            ->order(['Accounts.category'])
            ->all()
            ->extract('category')
            ->filter()
            ->combine(fn($v) => $v, fn($v) => $v)
            ->toArray();

        $this->set(compact('transactions', 'accounts', 'categories'));
    }

    // -----------------------------------------------------------------------
    // VIEW
    // -----------------------------------------------------------------------

    public function view(int $id)
    {
        $user = $this->Authentication->getIdentity();
        $transaction = $this->fetchTable('Transactions')
            ->get($id, contain: ['Accounts', 'Departments', 'Buildings', 'Tenants', 'Suppliers', 'Customers']);
        $this->set(compact('transaction'));
    }

    // -----------------------------------------------------------------------
    // ADD — single transaction line
    // -----------------------------------------------------------------------

    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Transactions = $this->fetchTable('Transactions');
        $transaction  = $Transactions->newEmptyEntity();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['company_id'] = $companyId;
            $transaction = $Transactions->patchEntity($transaction, $data);

            if ($this->request->getQuery('popup')) {
                if ($Transactions->save($transaction, ['check_balance' => false])) {
                    $this->set('popupResult', ['id' => $transaction->id, 'name' => $transaction->description]);
                    $this->viewBuilder()->disableAutoLayout();
                    return $this->render('/Element/popup_success');
                }
            }

            if ($Transactions->save($transaction, ['check_balance' => false])) {
                $this->Flash->success(__('Transaction saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not save transaction. Please check for errors.'));
        }

        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
        $this->set(compact('transaction', 'accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
    }

    // -----------------------------------------------------------------------
    // EDIT — single transaction line
    // -----------------------------------------------------------------------

    public function edit(int $id)
    {
        $companyId = $this->request->getAttribute('company_id');

        $Transactions = $this->fetchTable('Transactions');
        $transaction  = $Transactions->get($id);

        if ($this->request->is(['post', 'put'])) {
            $transaction = $Transactions->patchEntity($transaction, $this->request->getData());
            if ($Transactions->save($transaction, ['check_balance' => false])) {
                $this->Flash->success(__('Transaction updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not update transaction.'));
        }

        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
        $this->set(compact('transaction', 'accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
    }

    // -----------------------------------------------------------------------
    // DELETE — cascades whole transaction_group via afterDelete in model
    // -----------------------------------------------------------------------

    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyId = $this->request->getAttribute('company_id');

        $Transactions = $this->fetchTable('Transactions');
        $transaction  = $Transactions->find()
            ->where(['Transactions.id' => $id, 'Transactions.company_id' => $companyId])
            ->first();

        if ($transaction && $Transactions->delete($transaction)) {
            $this->Flash->success(__('Transaction (and its journal group) deleted.'));
        } else {
            $this->Flash->error(__('Could not delete transaction.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // -----------------------------------------------------------------------
    // BULK ADD — multi-line journal entry
    // -----------------------------------------------------------------------

    /**
     * GET  /transactions/bulk-add   → show the blank form
     * POST /transactions/bulk-add   → validate & save all lines atomically
     *
     * @return \Cake\Http\Response|null
     */
    public function bulkAdd()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Transactions = $this->fetchTable('Transactions');

        if ($this->request->is('post')) {
            $rows = (array)$this->request->getData('rows', []);

            if (count($rows) < 2) {
                $this->Flash->error('A journal entry requires at least two lines.');
                [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                $this->set(compact('accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                return null;
            }

            // --- Exchange-rate lookup for ZWG conversion ---
            $ExchangeRates = $this->fetchTable('ExchangeRates');
            $AccountsTable = $this->fetchTable('Accounts');

            // Fetch account details for validation
            $accountIds = array_filter(array_unique(array_map(fn($r) => (int)($r['account_id'] ?? 0), $rows)));
            $accountsMap = $AccountsTable->find()
                ->where(['id IN' => $accountIds])
                ->select(['id', 'name', 'category'])
                ->all()
                ->combine('id', fn($a) => $a)
                ->toArray();

            $groupId   = Text::uuid();
            $entities  = [];
            $zwgTotal  = 0.0;

            foreach ($rows as $index => $row) {
                $rowNum = $index + 1;
                $accId  = (int)($row['account_id'] ?? 0);
                $account = $accountsMap[$accId] ?? null;

                if ($account) {
                    $cat = $account->category;
                    // Enforce Customer for Receivable accounts
                    if (stripos($cat, 'Receivable') !== false && empty($row['customer_id'])) {
                        $this->Flash->error("Row #{$rowNum}: Customer is required for account '{$account->name}' (Receivable).");
                        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                        $this->set(compact('accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                        return null;
                    }
                    // Enforce Supplier for Payable accounts
                    if (stripos($cat, 'Payable') !== false && empty($row['supplier_id'])) {
                        $this->Flash->error("Row #{$rowNum}: Supplier is required for account '{$account->name}' (Payable).");
                        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                        $this->set(compact('accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                        return null;
                    }
                    // Enforce Building for Building-related accounts
                    if (stripos($cat, 'Building') !== false && empty($row['building_id'])) {
                        $this->Flash->error("Row #{$rowNum}: Building is required for account '{$account->name}' (Building).");
                        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                        $this->set(compact('accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                        return null;
                    }
                    // Enforce Tenant for Tenant-related accounts
                    if (stripos($cat, 'Tenant') !== false && empty($row['tenant_id'])) {
                        $this->Flash->error("Row #{$rowNum}: Tenant is required for account '{$account->name}' (Tenant).");
                        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                        $this->set(compact('accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                        return null;
                    }
                }

                $currency = $row['currency'] ?? 'USD';
                $amount   = (float)($row['amount'] ?? 0);
                $date     = $row['date'] ?? date('Y-m-d');
                $type     = $row['type'] ?? 'Debit';

                // Resolve ZWG equivalent
                $rate = $ExchangeRates->find()
                    ->where(['company_id' => $companyId, 'currency' => $currency])
                    ->where(['date <=' => $date])
                    ->orderBy(['date' => 'DESC'])
                    ->first();

                $rateValue = $rate ? (float)$rate->rate_to_base : 1.0;
                $zwg       = $amount * $rateValue;

                $isDebit  = in_array(strtolower(trim($type)), ['debit', '1']);
                $zwgTotal += $isDebit ? $zwg : -$zwg;

                $data = [
                    'company_id'         => $companyId,
                    'date'               => $date,
                    'description'        => $row['description'] ?? '',
                    'currency'           => $currency,
                    'amount'             => $amount,
                    'zwg'                => $zwg,
                    'type'               => $isDebit ? 'Debit' : 'Credit',
                    'account_id'         => (int)($row['account_id'] ?? 0),
                    'customer_id'        => !empty($row['customer_id'])   ? (int)$row['customer_id']   : null,
                    'supplier_id'        => !empty($row['supplier_id'])   ? (int)$row['supplier_id']   : null,
                    'building_id'        => !empty($row['building_id'])   ? (int)$row['building_id']   : null,
                    'tenant_id'          => !empty($row['tenant_id'])     ? (int)$row['tenant_id']     : null,
                    'department_id'      => !empty($row['department_id']) ? (int)$row['department_id'] : null,
                    'transaction_group'  => $groupId,
                ];
                $entities[] = $Transactions->newEntity($data, ['validate' => false]);
            }

            // Validate zero‑sum (ZWG)
            if (abs($zwgTotal) > 0.01) {
                $this->Flash->error(sprintf(
                    'Journal is out of balance (ZWG net: %.4f). Debits must equal Credits.',
                    $zwgTotal
                ));
                [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                $this->set(compact('accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                return null;
            }

            $saved = $Transactions->getConnection()->transactional(function () use ($Transactions, $entities) {
                foreach ($entities as $entity) {
                    if (!$Transactions->save($entity, ['check_balance' => false])) {
                        return false;
                    }
                }
                return true;
            });

            if ($saved) {
                $this->Flash->success('Bulk journal entry posted successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not save journal entry. Please check for errors.');
        }

        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
        $this->set(compact('accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
    }

    // -----------------------------------------------------------------------
    // BULK EDIT — update an existing journal group
    // -----------------------------------------------------------------------

    /**
     * GET  /transactions/bulk-edit/{groupId}  → load existing lines into form
     * POST /transactions/bulk-edit/{groupId}  → delete old lines, re-insert new ones
     *
     * @param string $groupId UUID of the transaction_group to edit.
     * @return \Cake\Http\Response|null
     */
    public function bulkEdit(string $groupId)
    {
        $companyId = $this->request->getAttribute('company_id');

        $Transactions = $this->fetchTable('Transactions');

        $journalLines = $Transactions->find()
            ->where([
                'Transactions.transaction_group' => $groupId,
                'Transactions.company_id'        => $companyId,
            ])
            ->contain(['Accounts'])
            ->order(['Transactions.id'])
            ->all();

        if ($journalLines->isEmpty()) {
            $this->Flash->error('Journal group not found.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $rows = (array)$this->request->getData('rows', []);

            if (count($rows) < 2) {
                $this->Flash->error('A journal entry requires at least two lines.');
                [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                $this->set(compact('journalLines', 'groupId', 'accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                return null;
            }

            $ExchangeRates = $this->fetchTable('ExchangeRates');
            $AccountsTable = $this->fetchTable('Accounts');

            // Fetch account details for validation
            $accountIds = array_filter(array_unique(array_map(fn($r) => (int)($r['account_id'] ?? 0), $rows)));
            $accountsMap = $AccountsTable->find()
                ->where(['id IN' => $accountIds])
                ->select(['id', 'name', 'category'])
                ->all()
                ->combine('id', fn($a) => $a)
                ->toArray();

            $zwgTotal      = 0.0;
            $entities      = [];

            foreach ($rows as $index => $row) {
                $rowNum = $index + 1;
                $accId  = (int)($row['account_id'] ?? 0);
                $account = $accountsMap[$accId] ?? null;

                if ($account) {
                    $cat = $account->category;
                    // Enforce Customer for Receivable accounts
                    if (stripos($cat, 'Receivable') !== false && empty($row['customer_id'])) {
                        $this->Flash->error("Row #{$rowNum}: Customer is required for account '{$account->name}' (Receivable).");
                        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                        $this->set(compact('journalLines', 'groupId', 'accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                        return null;
                    }
                    // Enforce Supplier for Payable accounts
                    if (stripos($cat, 'Payable') !== false && empty($row['supplier_id'])) {
                        $this->Flash->error("Row #{$rowNum}: Supplier is required for account '{$account->name}' (Payable).");
                        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                        $this->set(compact('journalLines', 'groupId', 'accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                        return null;
                    }
                    // Enforce Building for Building-related accounts
                    if (stripos($cat, 'Building') !== false && empty($row['building_id'])) {
                        $this->Flash->error("Row #{$rowNum}: Building is required for account '{$account->name}' (Building).");
                        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                        $this->set(compact('journalLines', 'groupId', 'accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                        return null;
                    }
                    // Enforce Tenant for Tenant-related accounts
                    if (stripos($cat, 'Tenant') !== false && empty($row['tenant_id'])) {
                        $this->Flash->error("Row #{$rowNum}: Tenant is required for account '{$account->name}' (Tenant).");
                        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                        $this->set(compact('journalLines', 'groupId', 'accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                        return null;
                    }
                }

                $currency  = $row['currency'] ?? 'USD';
                $amount    = (float)($row['amount'] ?? 0);
                $date      = $row['date'] ?? date('Y-m-d');
                $type      = $row['type'] ?? 'Debit';

                $rate = $ExchangeRates->find()
                    ->where(['company_id' => $companyId, 'currency' => $currency])
                    ->where(['date <=' => $date])
                    ->orderBy(['date' => 'DESC'])
                    ->first();

                $rateValue = $rate ? (float)$rate->rate_to_base : 1.0;
                $zwg       = $amount * $rateValue;
                $isDebit   = in_array(strtolower(trim($type)), ['debit', '1']);
                $zwgTotal += $isDebit ? $zwg : -$zwg;

                // If an id was passed, update in place; otherwise create a new entity
                $existingId = !empty($row['id']) ? (int)$row['id'] : null;
                $data = [
                    'company_id'        => $companyId,
                    'date'              => $date,
                    'description'       => $row['description'] ?? '',
                    'currency'          => $currency,
                    'amount'            => $amount,
                    'zwg'               => $zwg,
                    'type'              => $isDebit ? 'Debit' : 'Credit',
                    'account_id'        => (int)($row['account_id'] ?? 0),
                    'customer_id'       => !empty($row['customer_id'])   ? (int)$row['customer_id']   : null,
                    'supplier_id'       => !empty($row['supplier_id'])   ? (int)$row['supplier_id']   : null,
                    'building_id'       => !empty($row['building_id'])   ? (int)$row['building_id']   : null,
                    'tenant_id'         => !empty($row['tenant_id'])     ? (int)$row['tenant_id']     : null,
                    'department_id'     => !empty($row['department_id']) ? (int)$row['department_id'] : null,
                    'transaction_group' => $groupId,
                ];

                if ($existingId) {
                    $existing = $Transactions->find()->where(['Transactions.id' => $existingId, 'Transactions.company_id' => $companyId])->first();
                    $entity   = $existing ? $Transactions->patchEntity($existing, $data) : $Transactions->newEntity($data, ['validate' => false]);
                } else {
                    $entity = $Transactions->newEntity($data, ['validate' => false]);
                }

                $entities[] = $entity;
            }

            if (abs($zwgTotal) > 0.01) {
                $this->Flash->error(sprintf(
                    'Journal is out of balance (ZWG net: %.4f). Debits must equal Credits.',
                    $zwgTotal
                ));
                [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
                $this->set(compact('journalLines', 'groupId', 'accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
                return null;
            }

            // Collect IDs that should be KEPT (those with existing id in submitted rows)
            $keptIds = array_filter(array_map(fn($r) => !empty($r['id']) ? (int)$r['id'] : null, $rows));

            $saved = $Transactions->getConnection()->transactional(function () use (
                $Transactions, $entities, $groupId, $companyId, $keptIds
            ) {
                // Delete lines that were removed
                $Transactions->deleteAll([
                    'transaction_group' => $groupId,
                    'company_id'        => $companyId,
                    'id NOT IN'         => !empty($keptIds) ? $keptIds : [0],
                ]);

                // Save all lines
                foreach ($entities as $entity) {
                    if (!$Transactions->save($entity, ['check_balance' => false])) {
                        return false;
                    }
                }
                return true;
            });

            if ($saved) {
                $this->Flash->success('Journal entry updated successfully.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not update journal entry.');
        }

        [$accounts, $departments, $buildings, $tenants, $suppliers, $customers] = $this->_dropdowns($companyId);
        $this->set(compact('journalLines', 'groupId', 'accounts', 'departments', 'buildings', 'tenants', 'suppliers', 'customers'));
    }

    // -----------------------------------------------------------------------
    // AJAX — BULK ACTION (delete)
    // -----------------------------------------------------------------------

    /**
     * POST /transactions/bulk-action
     *
     * @return \Cake\Http\Response JSON
     */
    public function bulkAction()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);

        $companyId = $this->request->getAttribute('company_id');
        $action    = $this->request->getData('action');
        $ids       = (array)$this->request->getData('ids', []);

        if (empty($ids)) {
            $this->set(['success' => false, 'message' => 'No IDs provided.']);
            return null;
        }

        if ($action === 'delete') {
            $Transactions = $this->fetchTable('Transactions');

            // Collect transaction_groups first so we can cascade
            $groups = $Transactions->find()
                ->where(['Transactions.id IN' => $ids, 'Transactions.company_id' => $companyId])
                ->select(['transaction_group'])
                ->distinct(['transaction_group'])
                ->all()
                ->extract('transaction_group')
                ->filter()
                ->toArray();

            // Delete entire groups
            if (!empty($groups)) {
                $Transactions->deleteAll([
                    'Transactions.transaction_group IN' => $groups,
                    'Transactions.company_id'           => $companyId,
                ]);
            }

            $this->set(['success' => true, 'message' => 'Selected transactions (and their journal partners) deleted.']);
        } else {
            $this->set(['success' => false, 'message' => 'Unknown action.']);
        }

        return null;
    }

    // -----------------------------------------------------------------------
    // PRIVATE HELPERS
    // -----------------------------------------------------------------------

    /**
     * Build common dropdown lists used across add/edit/bulkAdd/bulkEdit.
     *
     * @param int $companyId
     * @return array [$accounts, $departments, $buildings, $tenants, $suppliers, $customers]
     */
    private function _dropdowns(int $companyId): array
    {
        $accounts = $this->fetchTable('Accounts')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Accounts.company_id' => $companyId])
            ->order(['Accounts.type', 'Accounts.name'])
            ->all();

        $departments = $this->fetchTable('Departments')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Departments.company_id' => $companyId])
            ->all();

        $buildings = $this->fetchTable('Buildings')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Buildings.company_id' => $companyId])
            ->all();

        $tenants = $this->fetchTable('Tenants')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Tenants.company_id' => $companyId])
            ->all();

        $suppliers = $this->fetchTable('Suppliers')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Suppliers.company_id' => $companyId])
            ->all();

        $customers = $this->fetchTable('Customers')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Customers.company_id' => $companyId])
            ->all();

        return [$accounts, $departments, $buildings, $tenants, $suppliers, $customers];
    }
}
