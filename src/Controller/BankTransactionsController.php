<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * BankTransactions Controller
 *
 * Handles bank statement import/reconciliation, categorisation (single, bulk, split),
 * and the AJAX API endpoints consumed by the dashboard JS.
 */
class BankTransactionsController extends AppController
{
    // -----------------------------------------------------------------------
    // DASHBOARD
    // -----------------------------------------------------------------------

    /**
     * Reconciliation dashboard — shows unreconciled bank lines and recent history.
     *
     * Variables:
     *   $bankTransactions  — unreconciled rows
     *   $recentReconciled  — last 15 reconciled rows
     *   $accounts          — [id => name] list for categorize dropdowns
     */
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $BankTransactions = $this->fetchTable('BankTransactions');

        // Unreconciled lines
        $bankTransactions = $BankTransactions->find()
            ->where([
                'BankTransactions.company_id' => $companyId,
                'BankTransactions.reconciled' => 0,
            ])
            ->contain(['BankAccounts'])
            ->order(['BankTransactions.date' => 'ASC'])
            ->all();

        // Apply simple suggestion: last-used account per description keyword
        $BankRules = $this->fetchTable('BankRules');
        $rulesQuery = $BankRules->find()
            ->select(['match_text', 'account_id'])
            ->where(['company_id' => $companyId])
            ->all();
        
        $rules = [];
        foreach ($rulesQuery as $row) {
            $rules[strtolower($row->match_text)] = $row->account_id;
        }

        $txList = $bankTransactions->toList();
        foreach ($txList as $tx) {
            $desc = strtolower($tx->description ?? '');
            foreach ($rules as $keyword => $accountId) {
                if (str_contains($desc, $keyword)) {
                    $tx->suggested_account_id = $accountId;
                    break;
                }
            }
        }

        // Last 15 reconciled
        $recentReconciled = $BankTransactions->find()
            ->where([
                'BankTransactions.company_id' => $companyId,
                'BankTransactions.reconciled' => 1,
            ])
            ->contain(['BankAccounts'])
            ->order(['BankTransactions.modified' => 'DESC'])
            ->limit(15)
            ->all();

        // Account list for dropdowns
        $Accounts = $this->fetchTable('Accounts');
        $accounts = $Accounts->find('list', keyField: 'id', valueField: 'name')
            ->where(['Accounts.company_id' => $companyId])
            ->order(['Accounts.type', 'Accounts.name'])
            ->all()
            ->toArray();

        $this->set(compact('bankTransactions', 'recentReconciled', 'accounts'));
    }

    // -----------------------------------------------------------------------
    // CSV IMPORT
    // -----------------------------------------------------------------------

    /**
     * Import a CSV bank statement.
     *
     * @return \Cake\Http\Response|null
     */
    public function import()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Accounts = $this->fetchTable('Accounts');
        $bankAccounts = $Accounts->find('list', keyField: 'id', valueField: 'name')
            ->where(['Accounts.company_id' => $companyId, 'Accounts.type' => 'Asset'])
            ->all();

        if ($this->request->is('post')) {
            $file        = $this->request->getUploadedFile('csv_file');
            $bankAcctId  = $this->request->getData('bank_account_id');
            $errors      = [];
            $imported    = 0;

            if (!$file || $file->getError() !== UPLOAD_ERR_OK) {
                $this->Flash->error('Please upload a valid CSV file.');
                $this->set(compact('bankAccounts'));
                return null;
            }

            $tmpPath = $file->getStream()->getMetadata('uri');
            // Strip BOM
            $raw = file_get_contents($tmpPath);
            $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
            $lines = array_filter(explode("\n", $raw));

            $BankTransactions = $this->fetchTable('BankTransactions');

            $headerSkipped = false;
            $rowNum        = 0;

            foreach ($lines as $line) {
                $rowNum++;
                $line = trim($line);
                if (empty($line)) continue;

                // Normalise: strip quotes, split on comma
                $cols = str_getcsv($line);
                $cols = array_map('trim', $cols);

                if (!$headerSkipped) {
                    $headerSkipped = true;
                    // Detect header by looking for date/amount keywords
                    $header = array_map('strtolower', $cols);
                    if (in_array('date', $header) || in_array('amount', $header)) {
                        continue; // skip header row
                    }
                }

                // Expect: date, description, amount[, reference]
                if (count($cols) < 3) {
                    $errors[] = "Row $rowNum: Not enough columns (expected date, description, amount).";
                    continue;
                }

                [$rawDate, $desc, $rawAmount] = $cols;
                $reference = $cols[3] ?? '';

                // Parse date
                $date = null;
                foreach (['d/m/Y', 'Y-m-d', 'd-m-Y', 'm/d/Y'] as $fmt) {
                    $d = \DateTime::createFromFormat($fmt, trim($rawDate));
                    if ($d !== false) { $date = $d->format('Y-m-d'); break; }
                }
                if (!$date) {
                    $errors[] = "Row $rowNum: Cannot parse date '$rawDate'.";
                    continue;
                }

                // Parse amount
                $amount = (float) str_replace([',', ' '], '', $rawAmount);

                $tx = $BankTransactions->newEntity([
                    'company_id'      => $companyId,
                    'bank_account_id' => $bankAcctId ?: null,
                    'date'            => $date,
                    'description'     => substr($desc, 0, 255),
                    'amount'          => $amount,
                    'reference'       => substr($reference, 0, 100),
                    'reconciled'      => 0,
                ]);

                if ($BankTransactions->save($tx)) {
                    $imported++;
                } else {
                    $errors[] = "Row $rowNum: Save failed — " . json_encode($tx->getErrors());
                }
            }

            if ($imported > 0) {
                $this->Flash->success("$imported transaction(s) imported successfully.");
            }
            if (!empty($errors)) {
                $this->Flash->warning(implode('<br>', array_slice($errors, 0, 10)));
            }

            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('bankAccounts'));
    }

    // -----------------------------------------------------------------------
    // AJAX API — SINGLE CATEGORIZE
    // -----------------------------------------------------------------------

    /**
     * POST /bank-transactions/api-categorize
     * Categorizes one bank line → creates a pair of double-entry Transactions.
     *
     * @return \Cake\Http\Response JSON
     */
    public function apiCategorize()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);

        $companyId    = $this->request->getAttribute('company_id');
        $bankTxId     = (int)$this->request->getData('bank_transaction_id');
        $accountId    = (int)$this->request->getData('account_id');
        $saveRule     = (bool)$this->request->getData('save_rule');

        $BankTransactions = $this->fetchTable('BankTransactions');

        $bankTx = $BankTransactions->find()
            ->where(['BankTransactions.id' => $bankTxId, 'BankTransactions.company_id' => $companyId])
            ->first();

        if (!$bankTx) {
            $this->set(['success' => false, 'message' => 'Transaction not found.']);
            return null;
        }

        if ($bankTx->reconciled) {
            $this->set(['success' => false, 'message' => 'Already reconciled.']);
            return null;
        }

        $Accounts = $this->fetchTable('Accounts');
        $account  = $Accounts->find()->where(['id' => $accountId, 'company_id' => $companyId])->first();
        if (!$account) {
            $this->set(['success' => false, 'message' => 'Account not found.']);
            return null;
        }

        // Determine bank's own Account (the asset account the statement belongs to)
        $bankAccountId = $bankTx->bank_account_id;

        // Derive type: positive amount → money came IN to bank (bank Debit, account Credit)
        $amount   = (float)$bankTx->amount;
        $isInflow = $amount >= 0;
        $absAmt   = abs($amount);

        $groupId  = Text::uuid();
        $date     = $bankTx->date ? $bankTx->date->format('Y-m-d') : date('Y-m-d');
        $desc     = $bankTx->description;

        $Transactions = $this->fetchTable('Transactions');

        $result = $Transactions->getConnection()->transactional(function () use (
            $Transactions, $BankTransactions, $bankTx, $bankTxId, $bankAccountId,
            $accountId, $absAmt, $isInflow, $groupId, $date, $desc, $companyId, $saveRule, $account
        ) {
            // Line 1 — the bank account side
            $line1 = $Transactions->newEntity([
                'company_id'         => $companyId,
                'bank_transaction_id' => $bankTxId,
                'date'               => $date,
                'description'        => $desc,
                'currency'           => 'USD',
                'amount'             => $absAmt,
                'zwg'                => $absAmt,
                'type'               => $isInflow ? 'Debit' : 'Credit',
                'account_id'         => $bankAccountId ?: $accountId,
                'transaction_group'  => $groupId,
            ], ['validate' => false]);

            // Line 2 — the categorised account side
            $line2 = $Transactions->newEntity([
                'company_id'         => $companyId,
                'bank_transaction_id' => $bankTxId,
                'date'               => $date,
                'description'        => $desc,
                'currency'           => 'USD',
                'amount'             => $absAmt,
                'zwg'                => $absAmt,
                'type'               => $isInflow ? 'Credit' : 'Debit',
                'account_id'         => $accountId,
                'transaction_group'  => $groupId,
            ], ['validate' => false]);

            $saved1 = $Transactions->save($line1, ['check_balance' => false]);
            $saved2 = $Transactions->save($line2, ['check_balance' => false]);

            if (!$saved1 || !$saved2) {
                return false;
            }

            // Mark bank transaction as reconciled
            $bankTx->reconciled   = 1;
            $bankTx->transaction_id = $line1->id;
            $BankTransactions->save($bankTx);

            // Optionally save categorisation rule
            if ($saveRule) {
                $keyword = strtolower(substr(trim($desc), 0, 50));
                $BankRules = TableRegistry::getTableLocator()->get('BankRules');
                $rule = $BankRules->find()
                    ->where(['company_id' => $companyId, 'match_text' => $keyword])
                    ->first();
                if (!$rule) {
                    $rule = $BankRules->newEmptyEntity();
                    $rule->company_id = $companyId;
                    $rule->match_text = $keyword;
                }
                $rule->account_id = $accountId;
                $BankRules->save($rule);
            }

            return true;
        });

        if ($result) {
            $this->set(['success' => true, 'message' => 'Categorized.']);
        } else {
            $this->set(['success' => false, 'message' => 'Could not save ledger entries.']);
        }

        return null;
    }

    // -----------------------------------------------------------------------
    // AJAX API — BULK CATEGORIZE
    // -----------------------------------------------------------------------

    /**
     * POST /bank-transactions/api-bulk-categorize
     *
     * @return \Cake\Http\Response JSON
     */
    public function apiBulkCategorize()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');
        $this->viewBuilder()->setOption('serialize', ['success', 'message', 'count']);

        $companyId = $this->request->getAttribute('company_id');
        $ids       = (array)$this->request->getData('ids', []);
        $accountId = (int)$this->request->getData('account_id');

        if (empty($ids) || !$accountId) {
            $this->set(['success' => false, 'message' => 'Missing ids or account_id.', 'count' => 0]);
            return null;
        }

        $BankTransactions = $this->fetchTable('BankTransactions');
        $Transactions     = $this->fetchTable('Transactions');

        $count = 0;

        foreach ($ids as $id) {
            $id    = (int)$id;
            $bankTx = $BankTransactions->find()
                ->where(['BankTransactions.id' => $id, 'BankTransactions.company_id' => $companyId, 'BankTransactions.reconciled' => 0])
                ->first();
            if (!$bankTx) continue;

            $amount   = (float)$bankTx->amount;
            $isInflow = $amount >= 0;
            $absAmt   = abs($amount);
            $groupId  = Text::uuid();
            $date     = $bankTx->date ? $bankTx->date->format('Y-m-d') : date('Y-m-d');
            $desc     = $bankTx->description;
            $bankAccountId = $bankTx->bank_account_id;

            $ok = $Transactions->getConnection()->transactional(function () use (
                $Transactions, $BankTransactions, $bankTx, $id, $bankAccountId,
                $accountId, $absAmt, $isInflow, $groupId, $date, $desc, $companyId
            ) {
                $line1 = $Transactions->newEntity([
                    'company_id'          => $companyId,
                    'bank_transaction_id' => $id,
                    'date'                => $date,
                    'description'         => $desc,
                    'currency'            => 'USD',
                    'amount'              => $absAmt,
                    'zwg'                 => $absAmt,
                    'type'                => $isInflow ? 'Debit' : 'Credit',
                    'account_id'          => $bankAccountId ?: $accountId,
                    'transaction_group'   => $groupId,
                ], ['validate' => false]);

                $line2 = $Transactions->newEntity([
                    'company_id'          => $companyId,
                    'bank_transaction_id' => $id,
                    'date'                => $date,
                    'description'         => $desc,
                    'currency'            => 'USD',
                    'amount'              => $absAmt,
                    'zwg'                 => $absAmt,
                    'type'                => $isInflow ? 'Credit' : 'Debit',
                    'account_id'          => $accountId,
                    'transaction_group'   => $groupId,
                ], ['validate' => false]);

                if (!$Transactions->save($line1, ['check_balance' => false])) return false;
                if (!$Transactions->save($line2, ['check_balance' => false])) return false;

                $bankTx->reconciled    = 1;
                $bankTx->transaction_id = $line1->id;
                $BankTransactions->save($bankTx);

                return true;
            });

            if ($ok) $count++;
        }

        $this->set(['success' => true, 'message' => "$count transaction(s) categorized.", 'count' => $count]);
        return null;
    }

    // -----------------------------------------------------------------------
    // AJAX API — SPLIT CATEGORIZE
    // -----------------------------------------------------------------------

    /**
     * POST /bank-transactions/api-split-categorize
     * Splits one bank line across multiple ledger accounts.
     *
     * @return \Cake\Http\Response JSON
     */
    public function apiSplitCategorize()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);

        $companyId = $this->request->getAttribute('company_id');
        $bankTxId  = (int)$this->request->getData('bank_transaction_id');
        $splits    = (array)$this->request->getData('splits', []);

        $BankTransactions = $this->fetchTable('BankTransactions');
        $bankTx = $BankTransactions->find()
            ->where(['BankTransactions.id' => $bankTxId, 'BankTransactions.company_id' => $companyId, 'BankTransactions.reconciled' => 0])
            ->first();

        if (!$bankTx) {
            $this->set(['success' => false, 'message' => 'Transaction not found or already reconciled.']);
            return null;
        }

        if (empty($splits)) {
            $this->set(['success' => false, 'message' => 'No split lines provided.']);
            return null;
        }

        $totalBank  = abs((float)$bankTx->amount);
        $totalSplit = array_sum(array_column($splits, 'amount'));

        if (abs($totalBank - $totalSplit) > 0.005) {
            $this->set(['success' => false, 'message' => sprintf(
                'Split total (%.4f) does not match bank amount (%.4f).', $totalSplit, $totalBank
            )]);
            return null;
        }

        $Transactions     = $this->fetchTable('Transactions');
        $isInflow         = (float)$bankTx->amount >= 0;
        $groupId          = Text::uuid();
        $date             = $bankTx->date ? $bankTx->date->format('Y-m-d') : date('Y-m-d');
        $bankAccountId    = $bankTx->bank_account_id;

        $result = $Transactions->getConnection()->transactional(function () use (
            $Transactions, $BankTransactions, $bankTx, $bankTxId, $splits,
            $isInflow, $groupId, $date, $companyId, $bankAccountId, $totalBank
        ) {
            // One bank-side debit/credit for the full amount
            $bankLine = $Transactions->newEntity([
                'company_id'          => $companyId,
                'bank_transaction_id' => $bankTxId,
                'date'                => $date,
                'description'         => $bankTx->description,
                'currency'            => 'USD',
                'amount'              => $totalBank,
                'zwg'                 => $totalBank,
                'type'                => $isInflow ? 'Debit' : 'Credit',
                'account_id'          => $bankAccountId,
                'transaction_group'   => $groupId,
            ], ['validate' => false]);

            if (!$Transactions->save($bankLine, ['check_balance' => false])) return false;

            // One line per split
            foreach ($splits as $split) {
                $accId  = (int)$split['account_id'];
                $amt    = (float)$split['amount'];
                $line   = $Transactions->newEntity([
                    'company_id'          => $companyId,
                    'bank_transaction_id' => $bankTxId,
                    'date'                => $date,
                    'description'         => $bankTx->description,
                    'currency'            => 'USD',
                    'amount'              => $amt,
                    'zwg'                 => $amt,
                    'type'                => $isInflow ? 'Credit' : 'Debit',
                    'account_id'          => $accId,
                    'transaction_group'   => $groupId,
                ], ['validate' => false]);
                if (!$Transactions->save($line, ['check_balance' => false])) return false;
            }

            $bankTx->reconciled    = 1;
            $bankTx->transaction_id = $bankLine->id;
            $BankTransactions->save($bankTx);

            return true;
        });

        if ($result) {
            $this->set(['success' => true, 'message' => 'Split categorization saved.']);
        } else {
            $this->set(['success' => false, 'message' => 'Failed to save split entries.']);
        }

        return null;
    }

    // -----------------------------------------------------------------------
    // AJAX API — DELETE (single)
    // -----------------------------------------------------------------------

    /**
     * POST /bank-transactions/api-delete
     *
     * @return \Cake\Http\Response JSON
     */
    public function apiDelete()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);

        $companyId = $this->request->getAttribute('company_id');
        $id        = (int)$this->request->getData('id');

        $BankTransactions = $this->fetchTable('BankTransactions');
        $tx = $BankTransactions->find()
            ->where(['BankTransactions.id' => $id, 'BankTransactions.company_id' => $companyId])
            ->first();

        if (!$tx) {
            $this->set(['success' => false, 'message' => 'Not found.']);
            return null;
        }

        if ($BankTransactions->delete($tx)) {
            $this->set(['success' => true, 'message' => 'Deleted.']);
        } else {
            $this->set(['success' => false, 'message' => 'Delete failed.']);
        }

        return null;
    }

    // -----------------------------------------------------------------------
    // AJAX API — BULK ACTION (delete)
    // -----------------------------------------------------------------------

    /**
     * POST /bank-transactions/bulk-action
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
            $BankTransactions = $this->fetchTable('BankTransactions');
            $BankTransactions->deleteAll([
                'BankTransactions.id IN'       => $ids,
                'BankTransactions.company_id'  => $companyId,
                'BankTransactions.reconciled'  => 0,
            ]);
            $this->set(['success' => true, 'message' => count($ids) . ' record(s) deleted.']);
        } else {
            $this->set(['success' => false, 'message' => 'Unknown action.']);
        }

        return null;
    }

    // -----------------------------------------------------------------------
    // AJAX API — UNRECONCILE
    // -----------------------------------------------------------------------

    /**
     * POST /bank-transactions/api-unreconcile
     * Deletes the linked ledger entries and marks the bank line as unreconciled.
     *
     * @return \Cake\Http\Response JSON
     */
    public function apiUnreconcile()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);

        $companyId = $this->request->getAttribute('company_id');
        $id        = (int)$this->request->getData('id');

        $BankTransactions = $this->fetchTable('BankTransactions');
        $bankTx = $BankTransactions->find()
            ->where(['BankTransactions.id' => $id, 'BankTransactions.company_id' => $companyId])
            ->first();

        if (!$bankTx) {
            $this->set(['success' => false, 'message' => 'Transaction not found.']);
            return null;
        }

        $Transactions = $this->fetchTable('Transactions');

        $result = $Transactions->getConnection()->transactional(function () use (
            $Transactions, $BankTransactions, $bankTx, $id, $companyId
        ) {
            // Delete all system ledger lines linked to this bank transaction
            $Transactions->deleteAll([
                'Transactions.bank_transaction_id' => $id,
                'Transactions.company_id'          => $companyId,
            ]);

            // Also cascade via transaction_group if we have a transaction_id
            if ($bankTx->transaction_id) {
                $seed = $Transactions->find()
                    ->where(['Transactions.id' => $bankTx->transaction_id])
                    ->first();
                if ($seed && !empty($seed->transaction_group)) {
                    $Transactions->deleteAll(['transaction_group' => $seed->transaction_group]);
                }
            }

            // Reset bank line
            $bankTx->reconciled    = 0;
            $bankTx->transaction_id = null;
            $BankTransactions->save($bankTx);

            return true;
        });

        if ($result) {
            $this->set(['success' => true, 'message' => 'Unreconciled successfully.']);
        } else {
            $this->set(['success' => false, 'message' => 'Unreconcile failed.']);
        }

        return null;
    }

    // -----------------------------------------------------------------------
    // STANDARD CRUD (add/view/edit/delete kept for admin use)
    // -----------------------------------------------------------------------

    public function view(int $id)
    {
        $user      = $this->Authentication->getIdentity();
        $bankTx = $this->fetchTable('BankTransactions')
            ->get($id, contain: ['BankAccounts', 'SystemTransactions']);
        $this->set(compact('bankTx'));
    }

    public function add()
    {
        $BankTransactions = $this->fetchTable('BankTransactions');
        $bankTransaction  = $BankTransactions->newEmptyEntity();

        if ($this->request->is('post')) {
            $data['company_id'] = $this->request->getAttribute('company_id');
            $bankTransaction = $BankTransactions->patchEntity($bankTransaction, $data);
            if ($BankTransactions->save($bankTransaction)) {
                $this->Flash->success(__('Bank transaction saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not save transaction.'));
        }

        $this->set(compact('bankTransaction'));
    }

    public function edit(int $id)
    {
        $BankTransactions = $this->fetchTable('BankTransactions');
        $bankTransaction  = $BankTransactions->get($id);

        if ($this->request->is(['post', 'put'])) {
            $bankTransaction = $BankTransactions->patchEntity($bankTransaction, $this->request->getData());
            if ($BankTransactions->save($bankTransaction)) {
                $this->Flash->success(__('Bank transaction saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not save transaction.'));
        }

        $this->set(compact('bankTransaction'));
    }

    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $BankTransactions = $this->fetchTable('BankTransactions');
        $bankTransaction  = $BankTransactions->find()
            ->where(['BankTransactions.id' => $id, 'BankTransactions.company_id' => $this->request->getAttribute('company_id')])
            ->first();

        if ($bankTransaction && $BankTransactions->delete($bankTransaction)) {
            $this->Flash->success(__('Deleted.'));
        } else {
            $this->Flash->error(__('Could not delete.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
