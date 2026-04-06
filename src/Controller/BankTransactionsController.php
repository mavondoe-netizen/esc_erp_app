<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;

class BankTransactionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * Main Reconciliation Dashboard
     */
    public function index()
    {
        $bankTransactions = $this->BankTransactions->find()
            ->where(['reconciled' => false])
            ->contain(['BankAccounts'])
            ->order(['BankTransactions.date' => 'DESC'])
            ->all();

        // Fetch all rules for the current company
        $rules = $this->fetchTable('BankRules')->find()->all();
        
        // Match rules to transactions
        foreach ($bankTransactions as $tx) {
            foreach ($rules as $rule) {
                if (stripos($tx->get('description'), $rule->match_text) !== false) {
                    $tx->suggested_account_id = $rule->account_id;
                    break;
                }
            }
        }

        $accounts = $this->fetchTable('Accounts')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();

        // Get some recent system transactions to show for matching
        $systemTransactions = $this->fetchTable('Transactions')->find()
            ->where(['date >=' => date('Y-m-d', strtotime('-30 days'))])
            ->contain(['Accounts'])
            ->order(['date' => 'DESC'])
            ->limit(50)
            ->all();

        $this->set(compact('bankTransactions', 'accounts', 'systemTransactions'));
    }

    /**
     * CSV Import View/Action
     */
    public function import()
    {
        $accounts = $this->fetchTable('Accounts')->find('list', [
            'keyField'   => 'id',
            'valueField' => 'name'
        ])->toArray();

        if ($this->request->is('post')) {
            $file          = $this->request->getData('csv_file');
            $bankAccountId = $this->request->getData('bank_account_id');

            if (!$bankAccountId) {
                $this->Flash->error(__('Please select a bank account to import into.'));
            } elseif ($file && $file->getError() === UPLOAD_ERR_OK) {
                $tmpPath = $file->getStream()->getMetadata('uri');
                $content = file_get_contents($tmpPath);

                // ── 1. Strip UTF-8 BOM (causes gibberish in first field) ──────────────
                if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                    $content = substr($content, 3);
                }

                // ── 2. Detect & convert encoding to clean UTF-8 ──────────────────────
                $encoding = mb_detect_encoding($content, ['UTF-8', 'Windows-1252', 'ISO-8859-1', 'UTF-16LE', 'UTF-16BE'], true);
                if ($encoding && $encoding !== 'UTF-8') {
                    $content = mb_convert_encoding($content, 'UTF-8', $encoding);
                } else {
                    // Force valid UTF-8 — removes any broken multi-byte sequences
                    $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
                }

                // ── 3. Strip null bytes and carriage returns that corrupt fields ──────
                $content = str_replace(["\x00", "\r"], ['', ''], $content);

                // ── 4. Delimiter auto-detection ───────────────────────────────────────
                $delimiter  = ',';
                $firstLine  = explode("\n", $content)[0];
                if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
                    $delimiter = ';';
                } elseif (substr_count($firstLine, "\t") > substr_count($firstLine, ',')) {
                    $delimiter = "\t";
                }

                // ── 5. Parse via in-memory stream ─────────────────────────────────────
                $tempHandle = fopen('php://temp', 'r+');
                fwrite($tempHandle, $content);
                rewind($tempHandle);

                $header    = fgetcsv($tempHandle, 0, $delimiter);
                $rows      = [];
                $saveErrors = [];
                $metrics   = ['total' => 0, 'new' => 0, 'existing' => 0, 'skipped' => 0, 'restored' => 0];
                $companyId = \Cake\Core\Configure::read('Tenant.company_id');
                $conn      = $this->BankTransactions->getConnection();
                $lineNum   = 1; // header was line 1

                while (($data = fgetcsv($tempHandle, 0, $delimiter)) !== false) {
                    $lineNum++;

                    // Skip rows that have fewer than 3 meaningful columns
                    if (count($data) < 3) {
                        $metrics['skipped']++;
                        continue;
                    }

                    // Trim & sanitise every field — removes BOM remnants, non-printable chars
                    $data = array_map(function ($val) {
                        $val = trim((string)$val);
                        // Remove non-printable characters except space, tab, newline
                        $val = preg_replace('/[^\x09\x0A\x20-\x7E\x80-\xFF]/u', '', $val);
                        return $val;
                    }, $data);

                    $metrics['total']++;

                    // ── Date parsing ─────────────────────────────────────────────────
                    $dateStr = trim($data[0] ?? '');
                    if (empty($dateStr)) {
                        $metrics['skipped']++;
                        $saveErrors[] = "Row {$lineNum}: Empty date — skipped.";
                        continue;
                    }
                    $normDate = str_replace(['/', '.'], '-', $dateStr);
                    $datePart = explode(' ', $normDate)[0];
                    try {
                        $date = new \Cake\I18n\FrozenDate($datePart);
                    } catch (\Exception $e) {
                        $metrics['skipped']++;
                        $saveErrors[] = "Row {$lineNum}: Unrecognised date format '{$dateStr}' — skipped.";
                        continue;
                    }

                    // ── Description ───────────────────────────────────────────────────
                    $desc = $data[1];
                    if (empty($desc)) {
                        $metrics['skipped']++;
                        $saveErrors[] = "Row {$lineNum}: Empty description — skipped.";
                        continue;
                    }
                    // Truncate to DB column limit
                    $desc = mb_substr($desc, 0, 250);

                    // ── Amount ────────────────────────────────────────────────────────
                    $amountStr     = preg_replace('/[^\d.\-]/', '', (string)($data[2] ?? ''));
                    $numericAmount = (float)$amountStr;
                    if ($amountStr === '' || $amountStr === '-') {
                        $metrics['skipped']++;
                        $saveErrors[] = "Row {$lineNum}: Missing or non-numeric amount '{$data[2]}' — skipped.";
                        continue;
                    }

                    $dateFormatted = $date->format('Y-m-d');

                    // ── Deduplication (raw SQL — immune to TenantAware double-scoping) ─
                    $existingBankTx = $conn->execute(
                        'SELECT id, reconciled, transaction_id FROM bank_transactions
                         WHERE company_id     = ?
                           AND bank_account_id = ?
                           AND date           = ?
                           AND description    = ?
                           AND ABS(amount - ?) < 0.001
                         LIMIT 1',
                        [$companyId, $bankAccountId, $dateFormatted, $desc, $numericAmount]
                    )->fetch('assoc');

                    if (!$existingBankTx) {
                        $rows[] = [
                            'company_id'      => $companyId,
                            'bank_account_id' => $bankAccountId,
                            'date'            => $date,
                            'description'     => $desc,
                            'amount'          => $numericAmount,
                            'reference'       => mb_substr(trim($data[3] ?? ''), 0, 100) ?: null,
                            'reconciled'      => false,
                        ];
                        $metrics['new']++;
                    } else {
                        // It exists, but is it legitimately reconciled?
                        if ($existingBankTx['reconciled'] && $existingBankTx['transaction_id']) {
                            $txExists = $conn->execute('SELECT id FROM transactions WHERE id = ?', [$existingBankTx['transaction_id']])->fetch();
                            if (!$txExists) {
                                // The ledger transaction was deleted! Restore this bank line to be categorized again.
                                $conn->execute('UPDATE bank_transactions SET reconciled = 0, transaction_id = NULL WHERE id = ?', [$existingBankTx['id']]);
                                $metrics['restored']++;
                            } else {
                                $metrics['existing']++;
                            }
                        } else {
                            $metrics['existing']++;
                        }
                    }
                }
                fclose($tempHandle);

                // Show any row-level parse warnings collected above
                if (!empty($saveErrors)) {
                    $this->Flash->warning(__('Some rows were skipped: ' . implode(' | ', $saveErrors)));
                }

                if (empty($rows)) {
                    $this->Flash->info(__(
                        "Import complete — nothing new to save. Total rows in file: {0}. Already in system: {1}. Skipped (bad format): {2}.",
                        $metrics['total'], $metrics['existing'], $metrics['skipped']
                    ));
                } else {
                    // Save one-by-one so we can report individual failures clearly
                    $savedCount  = 0;
                    $failedRows  = [];
                    foreach ($rows as $idx => $rowData) {
                        $entity = $this->BankTransactions->newEntity($rowData);
                        if ($this->BankTransactions->save($entity)) {
                            $savedCount++;
                        } else {
                            $errs = [];
                            foreach ($entity->getErrors() as $field => $msgs) {
                                $errs[] = "{$field}: " . implode(', ', $msgs);
                            }
                            $failedRows[] = "Row " . ($idx + 2) . " [{$rowData['description']}]: " . implode('; ', $errs);
                        }
                    }

                    if (empty($failedRows)) {
                        $this->Flash->success(__(
                            "Successfully processed imports. (New: {0} | Restored: {1} | Existing: {2} | Skipped: {3})",
                            $savedCount, $metrics['restored'], $metrics['existing'], $metrics['skipped']
                        ));
                    } else {
                        $this->Flash->error(__(
                            "{0} rows saved. {1} rows failed validation: {2}",
                            $savedCount, count($failedRows), implode(' | ', $failedRows)
                        ));
                    }
                }
                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('accounts'));
    }

    /**
     * AJAX: Categorize on the fly
     */
    public function apiCategorize()
    {
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();
        
        $bankTxId = $data['bank_transaction_id'] ?? null;
        $accountId = $data['account_id'] ?? null;
        $saveRule = $data['save_rule'] ?? false;

        if (!$bankTxId || !$accountId) {
            return $this->response->withStatus(400)->withStringBody(json_encode(['message' => 'Missing data']));
        }

        $bankTx = $this->BankTransactions->get($bankTxId);
        $transactionsTable = $this->fetchTable('Transactions');
        $conn = $transactionsTable->getConnection();

        try {
            $conn->transactional(function () use ($bankTx, $accountId, $saveRule, $transactionsTable, $bankTxId) {
                // Leg 1: Target Account
                $txTarget = $transactionsTable->newEntity([
                    'date' => $bankTx->get('date'),
                    'description' => $bankTx->get('description'),
                    'amount' => abs((float)$bankTx->get('amount')),
                    'currency' => 'USD', // Mapping default for now
                    'zwg' => 0, // Placeholder
                    'type' => $bankTx->get('amount') > 0 ? 'Credit' : 'Debit',
                    'account_id' => $accountId,
                    'bank_transaction_id' => $bankTxId,
                    'company_id' => $bankTx->get('company_id')
                ]);
                $transactionsTable->saveOrFail($txTarget);

                // Leg 2: Bank Account
                $txBank = $transactionsTable->newEntity([
                    'date' => $bankTx->get('date'),
                    'description' => $bankTx->get('description'),
                    'amount' => abs((float)$bankTx->get('amount')),
                    'currency' => 'USD',
                    'zwg' => 0,
                    'type' => $bankTx->get('amount') > 0 ? 'Debit' : 'Credit',
                    'account_id' => $bankTx->get('bank_account_id'),
                    'bank_transaction_id' => $bankTxId,
                    'company_id' => $bankTx->get('company_id')
                ]);
                $transactionsTable->saveOrFail($txBank);

                // Mark bank line as reconciled
                $bankTx->set('reconciled', true);
                $bankTx->set('transaction_id', $txTarget->id);
                $this->BankTransactions->saveOrFail($bankTx);

                // Save rule if requested
                if ($saveRule) {
                    $rulesTable = $this->fetchTable('BankRules');
                    $ruleExists = $rulesTable->find()->where([
                        'company_id' => $bankTx->get('company_id'),
                        'match_text' => $bankTx->get('description')
                    ])->first();

                    if (!$ruleExists) {
                        $rule = $rulesTable->newEntity([
                            'company_id' => $bankTx->get('company_id'),
                            'match_text' => $bankTx->get('description'),
                            'account_id' => $accountId
                        ]);
                        $rulesTable->saveOrFail($rule);
                    }
                }
            });

            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => true, 'message' => 'Reconciled successfully with double entry']));

        } catch (\Exception $e) {
            return $this->response->withStatus(500)->withStringBody(json_encode(['message' => 'Ledger save failed: ' . $e->getMessage()]));
        }
    }

    /**
     * AJAX: Split Categorize
     */
    public function apiSplitCategorize()
    {
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();

        $bankTxId = $data['bank_transaction_id'] ?? null;
        $splits   = $data['splits'] ?? [];

        if (!$bankTxId || empty($splits)) {
            return $this->response->withStatus(400)->withStringBody(json_encode(['message' => 'Missing data']));
        }

        $bankTx     = $this->BankTransactions->get($bankTxId);
        $totalSplit = array_sum(array_map('floatval', array_column($splits, 'amount')));
        $bankAmount = (float)$bankTx->get('amount');

        if (abs(round((float)$totalSplit, 4) - round(abs((float)$bankAmount), 4)) > 0.0001) {
            return $this->response->withStatus(400)->withStringBody(json_encode([
                'message' => "Total split (" . number_format($totalSplit, 4) . ") must match bank amount (" . number_format(abs($bankAmount), 4) . ")"
            ]));
        }

        $transactionsTable = $this->fetchTable('Transactions');
        $conn              = $transactionsTable->getConnection();

        try {
            // Use transactional() instead of manual begin/commit/rollback.
            // This is CakePHP-safe: internally each save() uses savepoints which nest
            // correctly inside transactional() without corrupting the outer transaction.
            $conn->transactional(function () use ($splits, $bankTx, $bankTxId, $transactionsTable) {
                foreach ($splits as $split) {
                    if (empty($split['account_id']) || empty($split['amount'])) {
                        continue;
                    }
                    $tx = $transactionsTable->newEntity([
                        'date'                => $bankTx->get('date'),
                        'description'         => $bankTx->get('description') . ' (Split)',
                        'amount'              => abs((float)$split['amount']),
                        'currency'            => 'USD',
                        'zwg'                 => 0,
                        'type'                => $bankTx->get('amount') > 0 ? 'Credit' : 'Debit',
                        'account_id'          => $split['account_id'],
                        'bank_transaction_id' => $bankTxId,
                        'company_id'          => $bankTx->get('company_id'),
                    ]);
                    $transactionsTable->saveOrFail($tx);
                }

                // Leg 2: Bank Account
                $txBank = $transactionsTable->newEntity([
                    'date'                => $bankTx->get('date'),
                    'description'         => $bankTx->get('description'),
                    'amount'              => abs((float)$bankTx->get('amount')),
                    'currency'            => 'USD',
                    'zwg'                 => 0,
                    'type'                => $bankTx->get('amount') > 0 ? 'Debit' : 'Credit',
                    'account_id'          => $bankTx->get('bank_account_id'),
                    'bank_transaction_id' => $bankTxId,
                    'company_id'          => $bankTx->get('company_id'),
                ]);
                $transactionsTable->saveOrFail($txBank);

                // Mark bank line as reconciled
                $bankTx->set('reconciled', true);
                $this->BankTransactions->saveOrFail($bankTx);
            });

            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => true, 'message' => 'Split reconciled successfully']));

        } catch (\Exception $e) {
            return $this->response->withStatus(500)->withStringBody(json_encode(['message' => 'Split failed: ' . $e->getMessage()]));
        }
    }


    /**
     * AJAX: Delete Transaction
     */
    public function apiDelete()
    {
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->getData('id');
        
        if (!$id) {
            return $this->response->withStatus(400)->withStringBody(json_encode(['message' => 'Missing ID']));
        }

        $bankTx = $this->BankTransactions->find()->where(['id' => $id])->first();
        if (!$bankTx) {
            return $this->response->withStatus(404)->withStringBody(json_encode(['message' => 'Transaction not found']));
        }
        
        if ($bankTx->reconciled) {
             return $this->response->withStatus(400)->withStringBody(json_encode(['message' => 'Cannot delete a reconciled transaction. Unreconcile it first.']));
        }

        if ($this->BankTransactions->delete($bankTx)) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => true, 'message' => 'Deleted successfully']));
        }

        return $this->response->withStatus(500)->withStringBody(json_encode(['message' => 'Delete failed']));
    }

    /**
     * AJAX Endpoint to handle bulk actions specialized for Bank Transactions
     */
    public function bulkAction()
    {
        $this->request->allowMethod(['post', 'ajax']);
        $data = $this->request->getData();
        $ids = $data['ids'] ?? [];
        $action = $data['action'] ?? '';
        
        if (empty($ids)) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'No records selected.']));
        }

        try {
            if ($action === 'delete') {
                $reconciledCount = $this->BankTransactions->find()
                    ->where(['id IN' => $ids, 'reconciled' => true])
                    ->count();
                
                if ($reconciledCount > 0) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => false, 
                            'message' => "Cannot delete $reconciledCount reconciled transactions. Please unreconcile them first."
                        ]));
                }

                $entities = $this->BankTransactions->find()->where(['id IN' => $ids])->all();
                if ($this->BankTransactions->deleteMany($entities)) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode(['success' => true, 'message' => count($ids) . ' records deleted.']));
                }
            } elseif ($action === 'update') {
                // For bank transactions, we might want to prevent bulk updates of certain fields if reconciled
                $field = $data['field'] ?? '';
                $value = $data['value'] ?? null;

                $reconciledCount = $this->BankTransactions->find()
                    ->where(['id IN' => $ids, 'reconciled' => true])
                    ->count();

                if ($reconciledCount > 0 && in_array($field, ['amount', 'date'])) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => false, 
                            'message' => "Cannot update '$field' for reconciled transactions."
                        ]));
                }

                return parent::bulkAction(); // Fallback to generic if checks pass
            }
        } catch (\Exception $e) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => $e->getMessage()]));
        }

        return parent::bulkAction();
    }

    public function downloadTemplate()
    {
        $fileName = 'bank_transactions_template.csv';
        $header = ['Date', 'Description', 'Amount', 'Reference'];
        $sampleData = [
            [date('Y-m-d'), 'Sample Credit (Customer Payment)', '500.00', 'REF001'],
            [date('Y-m-d'), 'Sample Debit (Supplier Payment)', '-250.00', 'REF002']
        ];
        
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $header);
        foreach ($sampleData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        $this->response = $this->response->withType('text/csv')
            ->withDownload($fileName)
            ->withStringBody($csv);

        return $this->response;
    }
}
