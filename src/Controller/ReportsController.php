<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\Date;

/**
 * Reports Controller
 *
 * Generates all financial reports: Balance Sheet, Income Statement,
 * Cash Flow, General Ledger, Bank Schedule, ZIMRA PAYE, and the Report Builder.
 */
class ReportsController extends AppController
{
    /**
     * Reports index/dashboard.
     *
     * @return void
     */
    public function index()
    {
        // nothing needed — template handles link display
    }

    // -----------------------------------------------------------------------
    // BALANCE SHEET
    // -----------------------------------------------------------------------
    /**
     * Statement of Financial Position (Balance Sheet).
     *
     * Variables passed to view:
     *   $report  — associative array ['Assets' => [...], 'Liabilities' => [...], 'Equity' => [...]]
     *   $totals  — ['total_assets', 'total_liabilities', 'total_equity', 'retained_earnings', 'total_liabilities_equity']
     *   $endDate — the "as of" date string
     *
     * @return void
     */
    public function balanceSheet()
    {
        $user      = $this->Authentication->getIdentity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $currency  = $this->request->getQuery('currency', 'USD');
        if (is_array($currency)) $currency = $currency[0] ?? 'USD';
        $endDate   = $this->request->getQuery('end_date', date('Y-m-d'));

        $Accounts   = TableRegistry::getTableLocator()->get('Accounts');
        $Transactions = TableRegistry::getTableLocator()->get('Transactions');

        // Fetch all accounts for this company
        $accounts = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId])
            ->all();

        // Build a map: account_id => running balance
        // For Balance Sheet: use ALL transactions up to endDate
        $balanceField = $currency === 'ZWG' ? 'zwg' : 'amount';

        // Actually use a simpler raw aggregate approach
        $conn = $Transactions->getConnection();
        $sql  = "SELECT account_id, type, SUM($balanceField) as total
                 FROM transactions
                 WHERE company_id = :cid AND date <= :end
                 GROUP BY account_id, type";
        $stmt = $conn->execute($sql, [':cid' => $companyId, ':end' => $endDate]);
        $rows = $stmt->fetchAll('assoc');

        // Build net balance per account (Debit positive, Credit negative for Balance Sheet accounts)
        $balances = [];
        foreach ($rows as $row) {
            $aid = (int)$row['account_id'];
            if (!isset($balances[$aid])) $balances[$aid] = 0.0;
            $isDebit = in_array(strtolower(trim((string)$row['type'])), ['debit', '1']);
            $balances[$aid] += $isDebit ? (float)$row['total'] : -(float)$row['total'];
        }

        // Add opening balances
        foreach ($accounts as $acc) {
            $aid = (int)$acc->id;
            if (!isset($balances[$aid])) $balances[$aid] = 0.0;
            $balances[$aid] += (float)($acc->opening_balance ?? 0);
        }

        $report = [
            'Assets'      => [],
            'Liabilities' => [],
            'Equity'      => [],
        ];
        $totals = [
            'total_assets'              => 0.0,
            'total_liabilities'         => 0.0,
            'total_equity'              => 0.0,
            'retained_earnings'         => 0.0,
            'total_liabilities_equity'  => 0.0,
        ];

        // Income/Expense accounts contribute to retained earnings
        $incomeTotal  = 0.0;
        $expenseTotal = 0.0;

        foreach ($accounts as $acc) {
            $aid     = (int)$acc->id;
            $balance = $balances[$aid] ?? 0.0;
            $type    = strtolower($acc->type ?? '');
            $sub     = $acc->subcategory ?: $acc->category;

            $cat     = strtolower($acc->category ?? '');

            $isAsset = (strpos($type, 'asset') !== false || $cat === 'asset');
            $isLiability = (strpos($type, 'liability') !== false || $cat === 'liability');
            $isEquity = (strpos($type, 'equity') !== false || $cat === 'equity');
            $isRevenue = (strpos($type, 'income') !== false || strpos($type, 'revenue') !== false || $cat === 'revenue' || $cat === 'income');
            $isExpense = (strpos($type, 'expense') !== false || strpos($type, 'cost') !== false || $cat === 'expense' || $cat === 'cost of sales');

            if ($isAsset) {
                if (!isset($report['Assets'][$sub])) $report['Assets'][$sub] = [];
                $report['Assets'][$sub][$acc->name] = ['account_id' => $aid, 'actual' => $balance];
                $totals['total_assets'] += $balance;
            } elseif ($isLiability) {
                if (!isset($report['Liabilities'][$sub])) $report['Liabilities'][$sub] = [];
                $report['Liabilities'][$sub][$acc->name] = ['account_id' => $aid, 'actual' => -$balance];
                $totals['total_liabilities'] += -$balance;
            } elseif ($isEquity) {
                if (!isset($report['Equity'][$sub])) $report['Equity'][$sub] = [];
                $report['Equity'][$sub][$acc->name] = ['account_id' => $aid, 'actual' => -$balance];
                $totals['total_equity'] += -$balance;
            } elseif ($isRevenue) {
                $incomeTotal += -$balance;
            } elseif ($isExpense) {
                $expenseTotal += $balance;
            }
        }

        $totals['retained_earnings']        = $incomeTotal - $expenseTotal;
        $totals['total_equity']             += $totals['retained_earnings'];
        $totals['total_liabilities_equity'] = $totals['total_liabilities'] + $totals['total_equity'];

        $this->set(compact('report', 'totals', 'endDate', 'currency'));
    }

    // -----------------------------------------------------------------------
    // INCOME STATEMENT (P&L)
    // -----------------------------------------------------------------------
    /**
     * Income Statement / Profit & Loss.
     *
     * @return void
     */
    public function incomeStatement()
    {
        $user      = $this->Authentication->getIdentity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $currency  = $this->request->getQuery('currency', 'USD');
        if (is_array($currency)) $currency = $currency[0] ?? 'USD';
        $departmentId = $this->request->getQuery('department_id', null);

        $parseDate = function ($param, $default) {
            $val = $this->request->getQuery($param);
            if (empty($val)) return $default;
            if (is_array($val)) {
                return sprintf('%04d-%02d-%02d', $val['year'] ?? date('Y'), $val['month'] ?? 1, $val['day'] ?? 1);
            }
            return (string)$val;
        };

        // Ensure the Income Statement defaults to current year
        $startDate = $parseDate('start_date', date('Y-01-01'));
        $endDate   = $parseDate('end_date', date('Y-m-d'));

        $conn = TableRegistry::getTableLocator()->get('Transactions')->getConnection();
        $balanceField = $currency === 'ZWG' ? 't.zwg' : 't.amount';
        $ytdStart = date('Y-01-01', strtotime($endDate));

        $safeStart = sprintf("'%s'", $startDate);
        $safeEnd   = sprintf("'%s'", $endDate);
        $safeYtd   = sprintf("'%s'", $ytdStart);

        $sql = "SELECT a.name, a.type, a.subcategory, a.category, a.id as account_id,
                       SUM(CASE WHEN t.date BETWEEN $safeStart AND $safeEnd AND t.type IN ('Debit','1') THEN $balanceField ELSE 0 END) as period_debits,
                       SUM(CASE WHEN t.date BETWEEN $safeStart AND $safeEnd AND t.type IN ('Credit','2') THEN $balanceField ELSE 0 END) as period_credits,
                       SUM(CASE WHEN t.date BETWEEN $safeYtd AND $safeEnd AND t.type IN ('Debit','1') THEN $balanceField ELSE 0 END) as ytd_debits,
                       SUM(CASE WHEN t.date BETWEEN $safeYtd AND $safeEnd AND t.type IN ('Credit','2') THEN $balanceField ELSE 0 END) as ytd_credits
                FROM accounts a
                LEFT JOIN transactions t ON t.account_id = a.id
                    AND t.company_id = :cid
                    AND t.date BETWEEN $safeYtd AND $safeEnd
                WHERE a.company_id = :cid2
                    AND (
                        a.type LIKE '%Income%' OR a.type LIKE '%Revenue%' OR a.type LIKE '%Expense%' OR a.type LIKE '%Cost%'
                        OR a.category IN ('Income','Revenue','Expense','Cost of Sales','Cost')
                    )
                GROUP BY a.id, a.name, a.type, a.subcategory, a.category
                ORDER BY a.type, a.subcategory, a.name";

        $stmt = $conn->execute($sql, [
            ':cid' => $companyId, ':cid2' => $companyId
        ]);
        $rows = $stmt->fetchAll('assoc');

        $report = ['Revenue' => [], 'CostOfSales' => [], 'Expenses' => []];
        $totals = [
            'period_revenue' => 0.0, 'ytd_revenue' => 0.0, 'ytd_budget_revenue' => 0.0,
            'period_cogs' => 0.0, 'ytd_cogs' => 0.0, 'ytd_budget_cogs' => 0.0,
            'gross_profit' => 0.0, 'ytd_gross_profit' => 0.0, 'ytd_budget_gross_profit' => 0.0,
            'period_expenses' => 0.0, 'ytd_expenses' => 0.0, 'ytd_budget_expenses' => 0.0,
            'net_income' => 0.0, 'ytd_net_income' => 0.0, 'ytd_budget_net_income' => 0.0
        ];

        foreach ($rows as $row) {
            $cat  = strtolower((string)$row['category']);
            $type = strtolower((string)$row['type']);
            $sub  = $row['subcategory'] ?: $row['category'] ?: 'General';
            
            $periodNet = (float)$row['period_credits'] - (float)$row['period_debits'];
            $ytdNet    = (float)$row['ytd_credits'] - (float)$row['ytd_debits'];

            // Skip rendering any account spanning zeroes entirely to declutter the actual view
            if (abs($periodNet) < 0.01 && abs($ytdNet) < 0.01) {
                continue;
            }

            $isExpenseOrCost = (strpos($type, 'expense') !== false || strpos($type, 'cost') !== false || $cat === 'expense' || $cat === 'cost of sales');

            if ($isExpenseOrCost) {
                $periodNet = -$periodNet;
                $ytdNet    = -$ytdNet;
            }

            $entry = [
                'account_id' => $row['account_id'],
                'actual'     => $periodNet,
                'ytd_actual' => $ytdNet,
                'ytd_budget' => 0.0
            ];

            if (strpos($type, 'income') !== false || strpos($type, 'revenue') !== false || $cat === 'revenue' || $cat === 'income') {
                if (!isset($report['Revenue'][$sub])) $report['Revenue'][$sub] = [];
                $report['Revenue'][$sub][$row['name']] = $entry;
                $totals['period_revenue'] += $periodNet;
                $totals['ytd_revenue']    += $ytdNet;
            } elseif (strpos($type, 'cost') !== false || $cat === 'cost of sales') {
                if (!isset($report['CostOfSales'][$sub])) $report['CostOfSales'][$sub] = [];
                $report['CostOfSales'][$sub][$row['name']] = $entry;
                $totals['period_cogs'] += $periodNet;
                $totals['ytd_cogs']    += $ytdNet;
            } else {
                if (!isset($report['Expenses'][$sub])) $report['Expenses'][$sub] = [];
                $report['Expenses'][$sub][$row['name']] = $entry;
                $totals['period_expenses'] += $periodNet;
                $totals['ytd_expenses']    += $ytdNet;
            }
        }

        $totals['gross_profit'] = $totals['period_revenue'] - $totals['period_cogs'];
        $totals['ytd_gross_profit'] = $totals['ytd_revenue'] - $totals['ytd_cogs'];
        $totals['net_income'] = $totals['gross_profit'] - $totals['period_expenses'];
        $totals['ytd_net_income'] = $totals['ytd_gross_profit'] - $totals['ytd_expenses'];

        $departments = [];
        $targetCurrency = $currency;

        $this->set(compact('report', 'totals', 'startDate', 'endDate', 'targetCurrency', 'departments', 'departmentId'));
    }

    // -----------------------------------------------------------------------
    // GENERAL LEDGER
    // -----------------------------------------------------------------------
    /**
     * General Ledger report — detailed transaction listing per account.
     *
     * @return void
     */
    public function ledger()
    {
        $user      = $this->Authentication->getIdentity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $currency  = $this->request->getQuery('currency', 'USD');
        if (is_array($currency)) $currency = $currency[0] ?? 'USD';
        $startDate = $this->request->getQuery('start_date', date('Y-01-01'));
        $endDate   = $this->request->getQuery('end_date', date('Y-m-d'));
        $accountId = $this->request->getQuery('account_id', null);

        $Accounts = TableRegistry::getTableLocator()->get('Accounts');
        $accounts = $Accounts->find('list', keyField: 'id', valueField: 'name')
            ->where(['Accounts.company_id' => $companyId])
            ->order(['Accounts.type', 'Accounts.name'])
            ->all();

        $ledgerData = [];
        $openingBalance = 0.0;
        $closingBalance = 0.0;
        $account = null;

        if ($accountId) {
            $account = $Accounts->find()
                ->where(['Accounts.id' => $accountId, 'Accounts.company_id' => $companyId])
                ->first();

            if ($account) {
                $openingBalance = (float)($account->opening_balance ?? 0);

                $Transactions = TableRegistry::getTableLocator()->get('Transactions');
                $balanceField = $currency === 'ZWG' ? 'zwg' : 'amount';

                $transactions = $Transactions->find()
                    ->where([
                        'Transactions.company_id' => $companyId,
                        'Transactions.account_id' => $accountId,
                        'Transactions.date >='    => $startDate,
                        'Transactions.date <='    => $endDate,
                    ])
                    ->order(['Transactions.date' => 'ASC', 'Transactions.id' => 'ASC'])
                    ->all();

                // Calculate running balance and populate ledgerData for template
                $runningBalance = $openingBalance;
                foreach ($transactions as $tx) {
                    $isDebit = in_array(strtolower(trim((string)$tx->type)), ['debit', '1']);
                    $amount  = (float)($currency === 'ZWG' ? $tx->zwg : $tx->amount);
                    
                    $debit = $isDebit ? $amount : 0;
                    $credit = $isDebit ? 0 : $amount;
                    
                    $runningBalance += $isDebit ? $amount : -$amount;
                    
                    $ledgerData[] = [
                        'txn' => $tx,
                        'debit' => $debit,
                        'credit' => $credit,
                        'balance' => $runningBalance
                    ];
                }
                $closingBalance = $runningBalance;
            }
        }

        $targetCurrency = $currency;

        $this->set(compact(
            'accounts', 'ledgerData', 'openingBalance', 'closingBalance',
            'account', 'accountId', 'startDate', 'endDate', 'targetCurrency'
        ));
    }

    // -----------------------------------------------------------------------
    // CASH FLOW
    // -----------------------------------------------------------------------
    /**
     * Cash Flow Statement.
     *
     * @return void
     */
    public function cashFlow()
    {
        $user      = $this->Authentication->getIdentity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $currency  = $this->request->getQuery('currency', 'USD');
        if (is_array($currency)) $currency = $currency[0] ?? 'USD';
        $startDate = $this->request->getQuery('start_date', date('Y-01-01'));
        $endDate   = $this->request->getQuery('end_date', date('Y-m-d'));

        $conn = TableRegistry::getTableLocator()->get('Transactions')->getConnection();
        $balanceField = $currency === 'ZWG' ? 't.zwg' : 't.amount';

        $sql = "SELECT a.name, a.type, a.subcategory, a.category, a.id as account_id,
                       SUM(CASE WHEN t.type IN ('Debit','1') THEN $balanceField ELSE 0 END) as debits,
                       SUM(CASE WHEN t.type IN ('Credit','2') THEN $balanceField ELSE 0 END) as credits
                FROM accounts a
                LEFT JOIN transactions t ON t.account_id = a.id
                    AND t.company_id = :cid
                    AND t.date BETWEEN :start AND :end
                WHERE a.company_id = :cid2
                GROUP BY a.id, a.name, a.type, a.subcategory, a.category
                ORDER BY a.type, a.name";

        $stmt = $conn->execute($sql, [':cid' => $companyId, ':cid2' => $companyId, ':start' => $startDate, ':end' => $endDate]);
        $rows = $stmt->fetchAll('assoc');

        $report = [
            'Operating'  => [],
            'Investing'  => [],
            'Financing'  => [],
        ];
        $totals = [
            'operating' => 0.0, 
            'investing' => 0.0, 
            'financing' => 0.0, 
            'net_cash_flow' => 0.0,
            'net_increase_cash' => 0.0
        ];

        $operatingNet = 0.0;
        foreach ($rows as $row) {
            $cat  = strtolower((string)$row['category']);
            $type = strtolower((string)$row['type'] ?? '');
            $net  = (float)$row['credits'] - (float)$row['debits'];
            $entry = ['account_id' => $row['account_id'], 'actual' => $net];
            $sub  = $row['subcategory'] ?: $row['category'] ?: 'General';

            $isRevenue = (strpos($type, 'income') !== false || strpos($type, 'revenue') !== false || $cat === 'revenue' || $cat === 'income');
            $isExpense = (strpos($type, 'expense') !== false || strpos($type, 'cost') !== false || $cat === 'expense' || $cat === 'cost of sales');

            if ($isRevenue || $isExpense) {
                $operatingNet += $net;
                $report['OperatingActivities'][$row['name']] = $entry;
            } elseif ($type === 'asset') {
                $report['InvestingActivities'][$row['name']] = $entry;
                $totals['investing'] += $net;
            } else {
                $report['FinancingActivities'][$row['name']] = $entry;
                $totals['financing'] += $net;
            }
        }

        $report['NetIncome'] = $operatingNet;
        $totals['net_cash_operating'] = $operatingNet;
        $totals['net_increase_cash']  = $totals['net_cash_operating'] + $totals['investing'] + $totals['financing'];
        $totals['net_cash_financing'] = $totals['financing'];

        $this->set(compact('report', 'totals', 'startDate', 'endDate', 'currency'));
    }

    // -----------------------------------------------------------------------
    // TRIAL BALANCE
    // -----------------------------------------------------------------------
    /**
     * Trial Balance report — summaries of total debits and credits per account.
     *
     * @return void
     */
    public function trialBalance()
    {
        $user      = $this->Authentication->getIdentity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $currency  = $this->request->getQuery('currency', 'USD');
        if (is_array($currency)) $currency = $currency[0] ?? 'USD';
        
        $startDate = $this->request->getQuery('start_date', date('Y-01-01'));
        $endDate   = $this->request->getQuery('end_date', date('Y-12-31'));

        $Accounts = TableRegistry::getTableLocator()->get('Accounts');
        $conn = $Accounts->getConnection();
        $balanceField = $currency === 'ZWG' ? 't.zwg' : 't.amount';

        // Query to get total debits and credits for every account
        $sql = "SELECT a.id, a.name, a.type, a.opening_balance,
                       SUM(CASE WHEN t.type IN ('Debit','1') THEN $balanceField ELSE 0 END) as period_debits,
                       SUM(CASE WHEN t.type IN ('Credit','2') THEN $balanceField ELSE 0 END) as period_credits
                FROM accounts a
                LEFT JOIN transactions t ON t.account_id = a.id
                    AND t.company_id = :cid
                    AND t.date BETWEEN :start AND :end
                WHERE a.company_id = :cid2
                GROUP BY a.id, a.name, a.type, a.opening_balance
                ORDER BY a.type, a.name";

        $stmt = $conn->execute($sql, [
            ':cid' => $companyId, ':cid2' => $companyId, 
            ':start' => $startDate, ':end' => $endDate
        ]);
        $rows = $stmt->fetchAll('assoc');

        $trialBalance = [];
        $totals = ['debit' => 0.0, 'credit' => 0.0];

        foreach ($rows as $row) {
            $opening = (float)($row['opening_balance'] ?? 0);
            $pDebits = (float)$row['period_debits'];
            $pCredits = (float)$row['period_credits'];

            // For Trial Balance, we show separate Debit and Credit columns for the final status
            // Opening balance: Positive is Debit, Negative is Credit
            $netDebit = ($opening > 0 ? $opening : 0) + $pDebits;
            $netCredit = ($opening < 0 ? abs($opening) : 0) + $pCredits;

            // Normalize so an account has either a Debit balance OR a Credit balance
            $finalDebit = 0.0;
            $finalCredit = 0.0;
            
            if ($netDebit > $netCredit) {
                $finalDebit = $netDebit - $netCredit;
            } else {
                $finalCredit = $netCredit - $netDebit;
            }

            if ($finalDebit > 0 || $finalCredit > 0) {
                $trialBalance[] = [
                    'account_id' => $row['id'],
                    'name' => $row['name'],
                    'type' => $row['type'],
                    'debit' => $finalDebit,
                    'credit' => $finalCredit
                ];
                $totals['debit'] += $finalDebit;
                $totals['credit'] += $finalCredit;
            }
        }

        $this->set(compact('trialBalance', 'totals', 'startDate', 'endDate', 'currency'));
    }

    // -----------------------------------------------------------------------
    // BANK SCHEDULE
    // -----------------------------------------------------------------------
    /**
     * Bank Schedule — reconciliation status per bank account.
     *
     * @return void
     */
    public function bankSchedule()
    {
        $user      = $this->Authentication->getIdentity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $startDate = $this->request->getQuery('start_date', date('Y-01-01'));
        $endDate   = $this->request->getQuery('end_date', date('Y-m-d'));

        $BankTransactions = TableRegistry::getTableLocator()->get('BankTransactions');

        $conn   = $BankTransactions->getConnection();
        $sql    = "SELECT b.account_name, b.currency,
                          SUM(CASE WHEN b.reconciled=1 THEN b.amount ELSE 0 END) as reconciled_total,
                          SUM(CASE WHEN b.reconciled=0 THEN b.amount ELSE 0 END) as unreconciled_total,
                          COUNT(*) as total_count,
                          SUM(CASE WHEN b.reconciled=1 THEN 1 ELSE 0 END) as reconciled_count
                   FROM bank_transactions b
                   WHERE b.company_id = :cid
                     AND b.date BETWEEN :start AND :end
                   GROUP BY b.account_name, b.currency
                   ORDER BY b.account_name";

        $stmt = $conn->execute($sql, [':cid' => $companyId, ':start' => $startDate, ':end' => $endDate]);
        $bankSchedule = $stmt->fetchAll('assoc');

        $this->set(compact('bankSchedule', 'startDate', 'endDate'));
    }

    // -----------------------------------------------------------------------
    // ZIMRA PAYE
    // -----------------------------------------------------------------------
    /**
     * ZIMRA PAYE schedule / P2 report.
     *
     * @return void
     */
    public function zimraPaye()
    {
        $user      = $this->Authentication->getIdentity();
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');

        $PayPeriods = TableRegistry::getTableLocator()->get('PayPeriods');
        $payPeriods = $PayPeriods->find('list', keyField: 'id', valueField: 'name')
            ->where(['PayPeriods.company_id' => $companyId])
            ->order(['PayPeriods.start_date' => 'DESC'])
            ->all();

        $payPeriodId = $this->request->getQuery('pay_period_id');
        $payslips = [];
        $totals = [
            'basic_salary' => 0.0, 'allowances' => 0.0, 'gross_pay' => 0.0,
            'nssa' => 0.0, 'pension' => 0.0, 'medical_aid' => 0.0,
            'taxable_income' => 0.0, 'paye' => 0.0, 'aids_levy' => 0.0,
            'total_tax' => 0.0, 'net_pay' => 0.0
        ];

        if ($payPeriodId) {
            $Payslips = TableRegistry::getTableLocator()->get('Payslips');
            $payslips = $Payslips->find()
                ->where([
                    'Payslips.company_id'   => $companyId,
                    'Payslips.pay_period_id' => $payPeriodId,
                ])
                ->contain(['Employees'])
                ->all();

            foreach ($payslips as $slip) {
                $totals['basic_salary'] += (float)$slip->basic_salary;
                $totals['allowances']   += (float)$slip->allowances;
                $totals['gross_pay']    += (float)$slip->gross_pay;
                $totals['nssa']         += (float)$slip->nssa;
                $totals['pension']      += (float)$slip->pension;
                $totals['medical_aid']  += (float)$slip->medical_aid;
                $totals['taxable_income'] += (float)$slip->taxable_income;
                $totals['paye']         += (float)$slip->paye;
                $totals['aids_levy']    += (float)$slip->aids_levy;
                $totals['total_tax']    += ((float)$slip->paye + (float)$slip->aids_levy);
                $totals['net_pay']      += (float)$slip->net_pay;
            }
        }

        $this->set(compact('payPeriods', 'payslips', 'payPeriodId', 'totals'));
    }

    // -----------------------------------------------------------------------
    // REPORT BUILDER
    // -----------------------------------------------------------------------
    /**
     * Custom Report Builder.
     *
     * @return void
     */
    public function builder()
    {
        $tables = \Cake\Datasource\ConnectionManager::get('default')->getSchemaCollection()->listTables();
        $tableOptions = [];
        foreach ($tables as $t) {
            if (strpos($t, 'phinxlog') !== false) continue;
            $camel = \Cake\Utility\Inflector::camelize($t);
            $tableOptions[$camel] = \Cake\Utility\Inflector::humanize($t);
        }
        asort($tableOptions);
        $this->set(compact('tableOptions'));
    }

    /**
     * API Fetch Schema Columns for Builder
     */
    public function apiFetchColumns()
    {
        $this->request->allowMethod(['get']);
        $table = $this->request->getQuery('table');
        $assoc = $this->request->getQuery('association');
        
        $response = ['success' => false, 'message' => 'Init', 'columns' => [], 'associations' => []];
        try {
            $ormHelperTable = $assoc ?: $table;
            $tbl = \Cake\ORM\TableRegistry::getTableLocator()->get($ormHelperTable);
            $schema = $tbl->getSchema();
            $response['columns'] = $schema->columns();
            $response['prefix'] = $ormHelperTable;
            
            if (!$assoc) {
                $assocs = [];
                foreach ($tbl->associations() as $association) {
                    $assocs[] = ['name' => $association->getName(), 'type' => $association->type()];
                }
                $response['associations'] = $assocs;
            }
            $response['success'] = true;
            unset($response['message']);
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }

    /**
     * API Generate Report for Builder
     */
    public function apiGenerateReport()
    {
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();
        if (empty($data)) {
            $data = $this->request->input('json_decode', true);
        }
        
        $table = $data['table'] ?? '';
        $columns = $data['columns'] ?? [];
        $start = $data['start_date'] ?? null;
        $end = $data['end_date'] ?? null;
        
        $response = ['success' => false, 'data' => []];
        if (!$table || empty($columns)) {
            $response['message'] = 'Missing table or columns';
            return $this->response->withType('application/json')->withStringBody(json_encode($response));
        }
        
        try {
            $tbl = \Cake\ORM\TableRegistry::getTableLocator()->get($table);
            
            $contain = [];
            foreach ($columns as $col) {
                if (strpos($col, '.') !== false) {
                    list($alias, $field) = explode('.', $col);
                    if ($alias !== $table && !in_array($alias, $contain)) {
                        $contain[] = $alias;
                    }
                }
            }
            
            $query = $tbl->find()->contain($contain);
            
            $user = $this->Authentication->getIdentity();
            $companyId = \Cake\Core\Configure::read('Tenant.company_id');
            if ($tbl->hasField('company_id')) {
                $query->where(["$table.company_id" => $companyId]);
            }
            
            if ($start && $end) {
                if ($tbl->hasField('date')) {
                    $query->where(["$table.date >=" => $start, "$table.date <=" => $end]);
                } elseif ($tbl->hasField('created')) {
                    $query->where(["$table.created >=" => "$start 00:00:00", "$table.created <=" => "$end 23:59:59"]);
                }
            }
            
            $result = $query->limit(1000)->all()->toArray();
            $response['success'] = true;
            $response['data'] = $result;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }

    /**
     * Receivables Aging Report
     */
    public function receivablesAging()
    {
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $currency  = $this->request->getQuery('currency', 'USD');
        $asOfDate  = $this->request->getQuery('as_of_date', date('Y-m-d'));

        $Invoices = TableRegistry::getTableLocator()->get('Invoices');
        $Transactions = TableRegistry::getTableLocator()->get('Transactions');

        // Fetch all non-draft, non-paid invoices
        $invoices = $Invoices->find()
            ->where([
                'Invoices.company_id' => $companyId,
                'Invoices.status IN' => ['Approved', 'Sent', 'Partial'],
                'Invoices.date <=' => $asOfDate
            ])
            ->contain(['Customers'])
            ->all();

        $report = [];
        $totals = ['current' => 0, '30' => 0, '60' => 0, '90' => 0, 'total' => 0];

        foreach ($invoices as $inv) {
            $customerName = $inv->customer->name ?? 'Unknown';
            
            // Calculate balance for this specific invoice
            // Total Debits - Total Credits on this invoice_id
            $balanceField = $currency === 'ZWG' ? 'zwg' : 'amount';
            $txs = $Transactions->find()
                ->where(['invoice_id' => $inv->id, 'company_id' => $companyId, 'date <=' => $asOfDate])
                ->all();
            
            $balance = 0;
            foreach ($txs as $tx) {
                $isDebit = in_array(strtolower(trim((string)$tx->type)), ['debit', '1']);
                $balance += $isDebit ? (float)$tx->{$balanceField} : -(float)$tx->{$balanceField};
            }

            if (abs($balance) < 0.01) continue;

            $dateDiff = (strtotime($asOfDate) - strtotime($inv->date->format('Y-m-d'))) / (60 * 60 * 24);
            
            $bucket = 'current';
            if ($dateDiff > 90) $bucket = '90';
            elseif ($dateDiff > 60) $bucket = '60';
            elseif ($dateDiff > 30) $bucket = '30';

            if (!isset($report[$customerName])) {
                $report[$customerName] = ['current' => 0, '30' => 0, '60' => 0, '90' => 0, 'total' => 0];
            }

            $report[$customerName][$bucket] += $balance;
            $report[$customerName]['total'] += $balance;
            $totals[$bucket] += $balance;
            $totals['total'] += $balance;
        }

        $this->set(compact('report', 'totals', 'asOfDate', 'currency'));
    }

    /**
     * Payables Aging Report
     */
    public function payablesAging()
    {
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $currency  = $this->request->getQuery('currency', 'USD');
        $asOfDate  = $this->request->getQuery('as_of_date', date('Y-m-d'));

        $Bills = TableRegistry::getTableLocator()->get('Bills');
        $Transactions = TableRegistry::getTableLocator()->get('Transactions');

        // Fetch all non-draft bills
        $bills = $Bills->find()
            ->where([
                'Bills.company_id' => $companyId,
                'Bills.status !=' => 'Draft',
                'Bills.date <=' => $asOfDate
            ])
            ->contain(['Suppliers'])
            ->all();

        $report = [];
        $totals = ['current' => 0, '30' => 0, '60' => 0, '90' => 0, 'total' => 0];

        foreach ($bills as $bill) {
            $supplierName = $bill->supplier->name ?? 'Unknown';
            
            // Calculate balance for this specific bill
            // Total Credits - Total Debits on this bill_id (Payables are Credits)
            $balanceField = $currency === 'ZWG' ? 'zwg' : 'amount';
            $txs = $Transactions->find()
                ->where(['bill_id' => $bill->id, 'company_id' => $companyId, 'date <=' => $asOfDate])
                ->all();
            
            $balance = 0;
            foreach ($txs as $tx) {
                $isDebit = in_array(strtolower(trim((string)$tx->type)), ['debit', '1']);
                // For Payables, Credit increases the liability
                $balance += $isDebit ? -(float)$tx->{$balanceField} : (float)$tx->{$balanceField};
            }

            if (abs($balance) < 0.01) continue;

            $dateDiff = (strtotime($asOfDate) - strtotime($bill->date->format('Y-m-d'))) / (60 * 60 * 24);
            
            $bucket = 'current';
            if ($dateDiff > 90) $bucket = '90';
            elseif ($dateDiff > 60) $bucket = '60';
            elseif ($dateDiff > 30) $bucket = '30';

            if (!isset($report[$supplierName])) {
                $report[$supplierName] = ['current' => 0, '30' => 0, '60' => 0, '90' => 0, 'total' => 0];
            }

            $report[$supplierName][$bucket] += $balance;
            $report[$supplierName]['total'] += $balance;
            $totals[$bucket] += $balance;
            $totals['total'] += $balance;
        }

        $this->set(compact('report', 'totals', 'asOfDate', 'currency'));
    }
}
