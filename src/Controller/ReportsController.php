<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Reports Controller
 *
 */
class ReportsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // Simple dashboard for Reports
    }

    /**
     * ZIMRA PAYE Tax Return Report
     */
    public function zimraPaye()
    {
        $payPeriodsTable = $this->fetchTable('PayPeriods');
        $payslipsTable = $this->fetchTable('Payslips');

        // Fetch all active pay periods for the filter dropdown
        $payPeriods = $payPeriodsTable->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['start_date' => 'DESC']
        ])->toArray();

        // Get the requested pay period, default to latest
        $payPeriodId = $this->request->getQuery('pay_period_id');
        if (!$payPeriodId && !empty($payPeriods)) {
            $payPeriodId = array_key_first($payPeriods);
        }

        $payslips = [];
        $totals = [
            'basic_salary' => 0, 'allowances' => 0, 'gross_pay' => 0,
            'nssa' => 0, 'pension' => 0, 'medical_aid' => 0, 'taxable_income' => 0,
            'paye' => 0, 'aids_levy' => 0, 'total_tax' => 0, 'net_pay' => 0
        ];

        if ($payPeriodId) {
            $payslips = $payslipsTable->find()
                ->where(['pay_period_id' => $payPeriodId])
                ->contain(['Employees'])
                ->order(['Employees.last_name' => 'ASC', 'Employees.first_name' => 'ASC'])
                ->all();

            foreach ($payslips as $slip) {
                $totals['basic_salary'] += (float)$slip->basic_salary;
                $totals['allowances'] += (float)$slip->allowances;
                $totals['gross_pay'] += (float)$slip->gross_pay;
                $totals['nssa'] += (float)$slip->nssa;
                $totals['pension'] += (float)$slip->pension;
                $totals['medical_aid'] += (float)$slip->medical_aid;
                $totals['taxable_income'] += (float)$slip->taxable_income;
                $totals['paye'] += (float)$slip->paye;
                $totals['aids_levy'] += (float)$slip->aids_levy;
                $totals['total_tax'] += ((float)$slip->paye + (float)$slip->aids_levy);
                $totals['net_pay'] += (float)$slip->net_pay;
            }
        }

        $this->set(compact('payPeriods', 'payPeriodId', 'payslips', 'totals'));
    }

    /**
     * Bank Schedule Report
     * Outputs net pay aggregated by Employee Bank account details depending on currency
     */
    public function bankSchedule()
    {
        $payPeriodsTable = $this->fetchTable('PayPeriods');
        $payslipsTable = $this->fetchTable('Payslips');

        // Fetch all active pay periods for the filter dropdown
        $payPeriods = $payPeriodsTable->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'order' => ['start_date' => 'DESC']
        ])->toArray();

        // Get the requested pay period, default to latest
        $payPeriodId = $this->request->getQuery('pay_period_id');
        if (!$payPeriodId && !empty($payPeriods)) {
            $payPeriodId = array_key_first($payPeriods);
        }

        $currency = $this->request->getQuery('currency', 'USD');
        
        $bankSchedule = [];
        $totalTransfer = 0;

        if ($payPeriodId) {
            $payslips = $payslipsTable->find()
                ->where(['pay_period_id' => $payPeriodId])
                ->contain(['Employees'])
                ->all();

            foreach ($payslips as $slip) {
                $netPay = $currency === 'USD' ? (float)$slip->usd_net : (float)$slip->zwg_net;
                
                // Skip if employee doesn't earn anything in this currency
                if ($netPay <= 0) {
                    continue;
                }
                
                $bankName = $currency === 'USD' ? $slip->employee->usd_bank : $slip->employee->zwg_bank;
                $branchName = $currency === 'USD' ? $slip->employee->usd_branch : $slip->employee->zwg_branch;
                $accountNum = $currency === 'USD' ? $slip->employee->usd_account : $slip->employee->zwg_account;
                
                $bankName = trim((string)$bankName) ?: 'Unassigned Bank';
                
                if (!isset($bankSchedule[$bankName])) {
                    $bankSchedule[$bankName] = [
                        'employees' => [],
                        'total' => 0
                    ];
                }
                
                $bankSchedule[$bankName]['employees'][] = [
                    'employee_code' => $slip->employee->employee_code,
                    'name' => $slip->employee->first_name . ' ' . $slip->employee->last_name,
                    'branch' => $branchName ?: 'N/A',
                    'account' => $accountNum ?: 'N/A',
                    'net_pay' => $netPay
                ];
                
                $bankSchedule[$bankName]['total'] += $netPay;
                $totalTransfer += $netPay;
            }
        }
        
        // Sort grouped banks alphabetically
        ksort($bankSchedule);
        
        $this->set(compact('payPeriods', 'payPeriodId', 'currency', 'bankSchedule', 'totalTransfer'));
    }

    /**
     * Income Statement (Category 4 = Revenue, 5 = COGS, 6 = Expenses)
     */
    public function incomeStatement()
    {
        $transactionsTable = $this->fetchTable('Transactions');
        $budgetsTable = $this->fetchTable('Budgets');

        $startDate = $this->request->getQuery('start_date', date('Y-01-01'));
        $endDate = $this->request->getQuery('end_date', date('Y-m-t'));
        $departmentId = $this->request->getQuery('department_id');
        
        $where = [
            'date >=' => $startDate,
            'date <=' => $endDate,
            'Accounts.category IN' => ['Revenue', 'Expense']
        ];
        
        $targetCurrency = $this->request->getQuery('currency', 'USD');
        $ratesList = [];
        if ($targetCurrency !== 'USD') {
            $ratesList = $this->fetchTable('ExchangeRates')->find()
                ->where(['currency' => $targetCurrency])
                ->order(['date' => 'DESC'])
                ->all();
        }

        $convert = function($amount, $dateStr) use ($targetCurrency, $ratesList) {
            if ($targetCurrency === 'USD') return (float)$amount;
            $applicableRate = 1.0;
            foreach ($ratesList as $r) {
                if ($r->date->format('Y-m-d') <= $dateStr) {
                    $applicableRate = (float)$r->rate_to_base;
                    break;
                }
            }
            return (float)$amount * $applicableRate;
        };

        if ($departmentId) {
            $where['department_id'] = $departmentId;
        }
        $ytdStartDate = date('Y-01-01', strtotime($endDate));
        $endDateTime = new \DateTime($endDate);
        $monthOfYear = (int)$endDateTime->format('m');

        // 1. Fetch Current Period Transactions
        $transactions = $transactionsTable->find()
            ->contain(['Accounts'])
            ->where($where)
            ->all();

        $whereYTD = [
            'date >=' => $ytdStartDate,
            'date <=' => $endDate,
            'Accounts.category IN' => ['Revenue', 'Expense']
        ];
        if ($departmentId) {
            $whereYTD['department_id'] = $departmentId;
        }

        // 2. Fetch YTD Transactions
        $transactionsYTD = $transactionsTable->find()
            ->contain(['Accounts'])
            ->where($whereYTD)
            ->all();

        // 3. Fetch Budgets for the current year
        $budgets = $budgetsTable->find()
            ->contain(['Accounts'])
            ->where([
                'Budgets.start_date >=' => $ytdStartDate,
                'Budgets.end_date <=' => date('Y-12-31', strtotime($endDate))
            ])
            ->all();

        $report = [
            'Revenue' => [],
            'CostOfSales' => [],
            'Expenses' => [],
        ];

        $totals = [
            'period_revenue' => 0, 'period_cogs' => 0, 'period_expenses' => 0,
            'ytd_revenue' => 0, 'ytd_cogs' => 0, 'ytd_expenses' => 0,
            'ytd_budget_revenue' => 0, 'ytd_budget_cogs' => 0, 'ytd_budget_expenses' => 0
        ];

        // Helper to initialize account row
        $initAcc = function() {
            return ['actual' => 0, 'ytd_actual' => 0, 'ytd_budget' => 0, 'annual_budget' => 0, 'account_id' => null];
        };

        // Process Current Period
        foreach ($transactions as $txn) {
            $cat = $txn->account->category;
            $sub = $txn->account->subcategory ?: 'Other';
            $name = $txn->account->name;
            $amount = $convert((float)$txn->amount, $txn->date->format('Y-m-d'));
            $type = strtolower(trim((string)$txn->type));
            
            $isCogs = stripos((string)$sub, 'cost of goods sold') !== false || stripos((string)$cat, 'cost') !== false;

            if ($cat === 'Revenue') {
                $categoryName = 'Revenue';
            } elseif ($isCogs) {
                $categoryName = 'CostOfSales';
            } else {
                $categoryName = 'Expenses';
            }
            if (!isset($report[$categoryName][$sub][$name])) $report[$categoryName][$sub][$name] = $initAcc();

            $val = 0;
            if ($categoryName === 'Revenue') { // Revenue (Credit increase)
                $val = in_array($type, ['1', 'credit']) ? $amount : -$amount;
                $totals['period_revenue'] += $val;
            } else { // Expense/COGS (Debit increase)
                $val = in_array($type, ['2', 'debit']) ? $amount : -$amount;
                if ($categoryName === 'CostOfSales') $totals['period_cogs'] += $val; else $totals['period_expenses'] += $val;
            }
            $report[$categoryName][$sub][$name]['actual'] += $val;
            if (empty($report[$categoryName][$sub][$name]['account_id'])) $report[$categoryName][$sub][$name]['account_id'] = $txn->account_id;
        }

        // Process YTD Actuals
        foreach ($transactionsYTD as $txn) {
            $cat = $txn->account->category;
            $sub = $txn->account->subcategory ?: 'Other';
            $name = $txn->account->name;
            $amount = $convert((float)$txn->amount, $txn->date->format('Y-m-d'));
            $type = strtolower(trim((string)$txn->type));

            $isCogs = stripos((string)$sub, 'cost of goods sold') !== false || stripos((string)$cat, 'cost') !== false;

            if ($cat === 'Revenue') {
                $categoryName = 'Revenue';
            } elseif ($isCogs) {
                $categoryName = 'CostOfSales';
            } else {
                $categoryName = 'Expenses';
            }
            if (!isset($report[$categoryName][$sub][$name])) $report[$categoryName][$sub][$name] = $initAcc();

            $val = 0;
            if ($categoryName === 'Revenue') {
                $val = in_array($type, ['1', 'credit']) ? $amount : -$amount;
                $totals['ytd_revenue'] += $val;
            } else {
                $val = in_array($type, ['2', 'debit']) ? $amount : -$amount;
                if ($categoryName === 'CostOfSales') $totals['ytd_cogs'] += $val; else $totals['ytd_expenses'] += $val;
            }
            $report[$categoryName][$sub][$name]['ytd_actual'] += $val;
            if (empty($report[$categoryName][$sub][$name]['account_id'])) $report[$categoryName][$sub][$name]['account_id'] = $txn->account_id;
        }

        // Process Budgets (Prorated)
        foreach ($budgets as $b) {
            $cat = $b->account->category;
            $sub = $b->account->subcategory ?: 'Other';
            $name = $b->account->name;
            
            $isCogs = stripos((string)$sub, 'cost of goods sold') !== false || stripos((string)$cat, 'cost') !== false;

            if ($cat === 'Revenue') {
                $categoryName = 'Revenue';
            } elseif ($isCogs) {
                $categoryName = 'CostOfSales';
            } else {
                $categoryName = 'Expenses';
            }
            
            if (!isset($report[$categoryName][$sub][$name])) $report[$categoryName][$sub][$name] = $initAcc();
            
            $annual = (float)$b->amount;
            // Prorate YTD Budget: (Annual / 12) * Months elapsed up to $endDate
            $ytdBudget = ($annual / 12) * $monthOfYear;

            $report[$categoryName][$sub][$name]['annual_budget'] = $annual;
            $report[$categoryName][$sub][$name]['ytd_budget'] = $ytdBudget;

            if ($categoryName === 'Revenue') $totals['ytd_budget_revenue'] += $ytdBudget;
            elseif ($categoryName === 'CostOfSales') $totals['ytd_budget_cogs'] += $ytdBudget;
            else $totals['ytd_budget_expenses'] += $ytdBudget;
        }

        // Final Totals Aggregation
        $totals['gross_profit'] = $totals['period_revenue'] - $totals['period_cogs'];
        $totals['ytd_gross_profit'] = $totals['ytd_revenue'] - $totals['ytd_cogs'];
        $totals['ytd_budget_gross_profit'] = $totals['ytd_budget_revenue'] - $totals['ytd_budget_cogs'];
        
        $totals['net_income'] = $totals['gross_profit'] - $totals['period_expenses'];
        $totals['ytd_net_income'] = $totals['ytd_gross_profit'] - $totals['ytd_expenses'];
        $totals['ytd_budget_net_income'] = $totals['ytd_budget_gross_profit'] - $totals['ytd_budget_expenses'];

        $departments = $this->fetchTable('Departments')->find('list')->toArray();

        $this->set(compact('report', 'totals', 'startDate', 'endDate', 'departments', 'departmentId', 'targetCurrency'));
    }

    /**
     * Statement of Financial Position (Balance Sheet)
     * Category: 1 = Assets, 2 = Liabilities, 3 = Equity
     */
    public function balanceSheet()
    {
        $transactionsTable = $this->fetchTable('Transactions');

        // Balance sheets are cumulative up to a specific date
        $endDate = $this->request->getQuery('end_date', date('Y-m-d'));

        // Query all transactions up to end_date
        $transactions = $transactionsTable->find()
            ->contain(['Accounts'])
            ->where([
                'date <=' => $endDate
            ])
            ->all();

        $report = [
            'Assets' => [],
            'Liabilities' => [],
            'Equity' => []
        ];

        $totals = [
            'total_assets' => 0,
            'total_liabilities' => 0,
            'total_equity' => 0,
            'retained_earnings' => 0
        ];

        $targetCurrency = $this->request->getQuery('currency', 'USD');
        $ratesList = [];
        if ($targetCurrency !== 'USD') {
            $ratesList = $this->fetchTable('ExchangeRates')->find()
                ->where(['currency' => $targetCurrency])
                ->order(['date' => 'DESC'])
                ->all();
        }

        $convert = function($amount, $dateStr) use ($targetCurrency, $ratesList) {
            if ($targetCurrency === 'USD') return (float)$amount;
            $applicableRate = 1.0;
            foreach ($ratesList as $r) {
                if ($r->date->format('Y-m-d') <= $dateStr) {
                    $applicableRate = (float)$r->rate_to_base;
                    break;
                }
            }
            return (float)$amount * $applicableRate;
        };

        foreach ($transactions as $txn) {
            $cat = $txn->account->category;
            $name = $txn->account->name; 
            if (!is_string($name)) $name = (string)$name;
            
            $type = strtolower(trim((string)$txn->type));
            $isDebit = in_array($type, ['2', 'debit']);
            $isCredit = in_array($type, ['1', 'credit']);
            $amount = $convert((float)$txn->amount, $txn->date->format('Y-m-d'));

            $sub = $txn->account->subcategory ?: 'Other';
            if (!$sub) $sub = 'Other';

            // Initialize account row with opening balance if not exists
            if (!isset($report['Assets'][$sub][$name]) && $cat === 'Asset') {
                $ob = (float)($txn->account->opening_balance ?? 0);
                $report['Assets'][$sub][$name] = ['actual' => $ob, 'account_id' => $txn->account_id];
                $totals['total_assets'] += $ob;
            } elseif (!isset($report['Liabilities'][$sub][$name]) && $cat === 'Liability') {
                $ob = (float)($txn->account->opening_balance ?? 0);
                $report['Liabilities'][$sub][$name] = ['actual' => $ob, 'account_id' => $txn->account_id];
                $totals['total_liabilities'] += $ob;
            } elseif (!isset($report['Equity'][$sub][$name]) && $cat === 'Equity') {
                $ob = (float)($txn->account->opening_balance ?? 0);
                $report['Equity'][$sub][$name] = ['actual' => $ob, 'account_id' => $txn->account_id];
                $totals['total_equity'] += $ob;
            }

            if ($cat === 'Asset') { // Assets (Normal Debit Balance)
                $report['Assets'][$sub][$name]['actual'] += $isDebit ? $amount : -$amount;
                $totals['total_assets'] += $isDebit ? $amount : -$amount;
            } elseif ($cat === 'Liability') { // Liabilities (Normal Credit Balance)
                $report['Liabilities'][$sub][$name]['actual'] += $isCredit ? $amount : -$amount;
                $totals['total_liabilities'] += $isCredit ? $amount : -$amount;
            } elseif ($cat === 'Equity') { // Equity (Normal Credit Balance)
                $report['Equity'][$sub][$name]['actual'] += $isCredit ? $amount : -$amount;
                $totals['total_equity'] += $isCredit ? $amount : -$amount;
            } elseif (in_array($cat, ['Revenue', 'Expense'])) {
                // Calculate Retained Earnings implicitly from all P&L accounts up to this date
                if ($cat === 'Revenue') { // Revenue (Credit)
                    $totals['retained_earnings'] += $isCredit ? $amount : -$amount;
                } elseif ($cat === 'Expense') { // Expenses/COGS (Debit)
                    $totals['retained_earnings'] -= $isDebit ? $amount : -$amount;
                }
            }
        }

        // Catch accounts that HAVE an opening balance but NO transactions in this range
        $allAccountsWithOb = $this->fetchTable('Accounts')->find()
            ->where(['opening_balance !=' => 0])
            ->all();
        
        foreach ($allAccountsWithOb as $acc) {
            $cat = $acc->category;
            $sub = $acc->subcategory ?: 'Other';
            $name = $acc->name;
            $ob = (float)$acc->opening_balance;
            
            if ($cat === 'Asset') {
                if (!isset($report['Assets'][$sub][$name])) {
                    $report['Assets'][$sub][$name] = ['actual' => $ob, 'account_id' => $acc->id];
                    $totals['total_assets'] += $ob;
                }
            } elseif ($cat === 'Liability') {
                if (!isset($report['Liabilities'][$sub][$name])) {
                    $report['Liabilities'][$sub][$name] = ['actual' => $ob, 'account_id' => $acc->id];
                    $totals['total_liabilities'] += $ob;
                }
            } elseif ($cat === 'Equity') {
                if (!isset($report['Equity'][$sub][$name])) {
                    $report['Equity'][$sub][$name] = ['actual' => $ob, 'account_id' => $acc->id];
                    $totals['total_equity'] += $ob;
                }
            }
        }

        // Add Retained Earnings into total equity equation
        $totals['total_equity'] += $totals['retained_earnings'];

        // Mathematical Integrity Metric
        $totals['total_liabilities_equity'] = $totals['total_liabilities'] + $totals['total_equity'];

        $this->set(compact('report', 'totals', 'endDate', 'targetCurrency'));
    }

    /**
     * Statement of Cash Flows (Indirect Method)
     * Calculates Operating Cash Flow by adjusting Net Income for working capital variances.
     */
    public function cashFlow()
    {
        $transactionsTable = $this->fetchTable('Transactions');

        $startDate = $this->request->getQuery('start_date', date('Y-01-01'));
        $endDate = $this->request->getQuery('end_date', date('Y-m-t'));

        // Query transactions within date range
        $transactions = $transactionsTable->find()
            ->contain(['Accounts'])
            ->where([
                'date >=' => $startDate,
                'date <=' => $endDate
            ])
            ->all();

        $report = [
            'NetIncome' => 0,
            'OperatingActivities' => [],
            'InvestingActivities' => [],
            'FinancingActivities' => [],
        ];

        $totals = [
            'net_cash_operating' => 0,
            'net_cash_investing' => 0,
            'net_cash_financing' => 0,
            'net_increase_cash' => 0
        ];

        $targetCurrency = $this->request->getQuery('currency', 'USD');
        $ratesList = [];
        if ($targetCurrency !== 'USD') {
            $ratesList = $this->fetchTable('ExchangeRates')->find()
                ->where(['currency' => $targetCurrency])
                ->order(['date' => 'DESC'])
                ->all();
        }

        $convert = function($amount, $dateStr) use ($targetCurrency, $ratesList) {
            if ($targetCurrency === 'USD') return (float)$amount;
            $applicableRate = 1.0;
            foreach ($ratesList as $r) {
                if ($r->date->format('Y-m-d') <= $dateStr) {
                    $applicableRate = (float)$r->rate_to_base;
                    break;
                }
            }
            return (float)$amount * $applicableRate;
        };

        foreach ($transactions as $txn) {
            $cat = $txn->account->category;
            $name = $txn->account->name; 
            if (!is_string($name)) $name = (string)$name;
            
            $type = strtolower(trim((string)$txn->type));
            $isDebit = in_array($type, ['2', 'debit']);
            $isCredit = in_array($type, ['1', 'credit']);
            $amount = $convert((float)$txn->amount, $txn->date->format('Y-m-d'));

            // Calculate Period Net Income directly
            if (in_array($cat, ['Revenue', 'Expense'])) {
                if ($cat === 'Revenue') { // Revenue (Credit increase)
                    $report['NetIncome'] += $isCredit ? $amount : -$amount;
                } else { // Expenses (Debit increase)
                    $report['NetIncome'] -= $isDebit ? $amount : -$amount;
                }
            }
            
            // Operating Adjustments (Working Capital Changes)
            // Does not look at "Cash" explicitly. Finds changes in Receivables/Payables.
            $isCashAccount = (stripos($name, 'cash') !== false || stripos($name, 'bank') !== false);

            if (!$isCashAccount) {
                if ($cat === 'Asset') { // Assets (Increase is a cash OUTFLOW)
                    // If Debited (Asset increase), Cash decreased. If Credited (Asset decrease), Cash increased.
                    $cashImpact = $isCredit ? $amount : -$amount;
                    if (!isset($report['OperatingActivities'][$name])) $report['OperatingActivities'][$name] = ['actual' => 0, 'account_id' => $txn->account_id];
                    $report['OperatingActivities'][$name]['actual'] += $cashImpact;
                } elseif ($cat === 'Liability') { // Liabilities (Increase is a cash INFLOW)
                    // If Credited (Liab increase), Cash increased. If Debited (Liab decrease), Cash decreased.
                    $cashImpact = $isCredit ? $amount : -$amount;
                    if (!isset($report['OperatingActivities'][$name])) $report['OperatingActivities'][$name] = ['actual' => 0, 'account_id' => $txn->account_id];
                    $report['OperatingActivities'][$name]['actual'] += $cashImpact;
                } elseif ($cat === 'Equity') { // Equity items (Financing)
                    $cashImpact = $isCredit ? $amount : -$amount;
                    if (!isset($report['FinancingActivities'][$name])) $report['FinancingActivities'][$name] = ['actual' => 0, 'account_id' => $txn->account_id];
                    $report['FinancingActivities'][$name]['actual'] += $cashImpact;
                }
            }
        }

        // Drop empty activity variances
        foreach (['OperatingActivities', 'FinancingActivities'] as $actArea) {
            foreach ($report[$actArea] as $k => $v) {
                if (round($v['actual'] ?? 0, 2) == 0) unset($report[$actArea][$k]);
            }
        }

        // Aggregate Totals
        $opSum = array_reduce($report['OperatingActivities'], function($c, $i) { return $c + ($i['actual'] ?? 0); }, 0);
        $invSum = array_reduce($report['InvestingActivities'], function($c, $i) { return $c + ($i['actual'] ?? 0); }, 0);
        $finSum = array_reduce($report['FinancingActivities'], function($c, $i) { return $c + ($i['actual'] ?? 0); }, 0);

        $totals['net_cash_operating'] = $report['NetIncome'] + $opSum;
        $totals['net_cash_investing'] = $invSum; 
        $totals['net_cash_financing'] = $finSum;
        $totals['net_increase_cash'] = $totals['net_cash_operating'] + $totals['net_cash_investing'] + $totals['net_cash_financing'];

        $this->set(compact('report', 'totals', 'startDate', 'endDate', 'targetCurrency'));
    }

    /**
     * Entity Agnostic Report Builder - View Container
     */
    public function builder()
    {
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $tables = $conn->getSchemaCollection()->listTables();
        
        // Filter out system or join tables that shouldn't be queries directly
        $excluded = ['phinxlog', 'sessions', 'audit_logs'];
        $availableTables = array_diff($tables, $excluded);
        asort($availableTables);

        // Re-index for dropdown
        $tableOptions = [];
        foreach ($availableTables as $t) {
            $tableOptions[$t] = \Cake\Utility\Inflector::humanize($t);
        }

        $this->set(compact('tableOptions'));
    }

    /**
     * AJAX Endpoint to fetch allowed columns and available joins for a selected table/association
     */
    public function apiFetchColumns()
    {
        $this->request->allowMethod(['get', 'ajax']);
        $table = $this->request->getQuery('table');
        $association = $this->request->getQuery('association');
        
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $tables = $conn->getSchemaCollection()->listTables();
        
        if (!in_array($table, $tables)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Invalid table selected.']);
        }

        $ormTable = $this->fetchTable(\Cake\Utility\Inflector::camelize($table));
        
        // If we are looking for columns of an association of the primary table
        if ($association) {
            try {
                $assocObj = $ormTable->getAssociation($association);
                $targetTable = $assocObj->getTarget();
                $columns = $targetTable->getSchema()->columns();
                return $this->jsonResponse(['success' => true, 'columns' => $columns, 'prefix' => $association]);
            } catch (\Exception $e) {
                return $this->jsonResponse(['success' => false, 'message' => 'Association not found: ' . $association]);
            }
        }

        // Primary table columns + available associations
        $columns = $conn->getSchemaCollection()->describe($table)->columns();
        $associations = [];
        foreach ($ormTable->associations() as $assoc) {
            $associations[] = [
                'name' => $assoc->getName(),
                'type' => $assoc->type(),
                'target' => $assoc->getClassName() ?? $assoc->getName()
            ];
        }
        
        return $this->jsonResponse([
            'success' => true, 
            'columns' => $columns, 
            'associations' => $associations
        ]);
    }

    /**
     * AJAX Endpoint to dynamically query the table with joins
     */
    public function apiGenerateReport()
    {
        $this->request->allowMethod(['post', 'ajax']);
        
        $table = $this->request->getData('table');
        $selectedColumns = $this->request->getData('columns', []);
        $startDate = $this->request->getData('start_date');
        $endDate = $this->request->getData('end_date');
        
        if (empty($table) || empty($selectedColumns)) {
            return $this->jsonResponse(['success' => false, 'message' => 'Table and Columns are required']);
        }

        try {
            $ormTable = $this->fetchTable(\Cake\Utility\Inflector::camelize($table));
            $query = $ormTable->find();
            
            $associationsToContain = [];
            $selectMap = [];

            foreach ($selectedColumns as $col) {
                if (strpos($col, '.') !== false) {
                    list($assoc, $field) = explode('.', $col);
                    $associationsToContain[] = $assoc;
                    // We don't explicitly 'select' joined columns here to avoid 'column not found' 
                    // if the ORM handles it via contain(). But we can if needed.
                } else {
                    $selectMap[] = $col;
                }
            }

            if (!empty($selectMap)) {
                $query->select($selectMap);
            }

            if (!empty($associationsToContain)) {
                $query->contain(array_unique($associationsToContain));
            }

            // Dynamically apply date filters
            $schema = $ormTable->getSchema();
            if ($startDate && $endDate) {
                if ($schema->hasColumn('date')) {
                    $query->where(["{$table}.date >=" => $startDate, "{$table}.date <=" => $endDate]);
                } elseif ($schema->hasColumn('created')) {
                    $query->where(["{$table}.created >=" => $startDate, "{$table}.created <=" => $endDate]);
                }
            }

            $results = $query->limit(500)->toArray();

            return $this->jsonResponse(['success' => true, 'data' => $results]);
        } catch (\Exception $e) {
            return $this->jsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Internal helper for JSON responses
     */
    private function jsonResponse($data)
    {
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    /**
     * Ledger Drilldown
     */
    public function ledger()
    {
        $accountId = $this->request->getQuery('account_id');
        $startDate = $this->request->getQuery('start_date', date('Y-01-01'));
        $endDate = $this->request->getQuery('end_date', date('Y-m-t'));
        $targetCurrency = $this->request->getQuery('currency', 'USD');

        if (!$accountId) {
            $this->Flash->error(__('Invalid account for ledger drilldown.'));
            return $this->redirect($this->referer());
        }

        $account = $this->fetchTable('Accounts')->get($accountId);

        $ratesList = [];
        if ($targetCurrency !== 'USD') {
            $ratesList = $this->fetchTable('ExchangeRates')->find()
                ->where(['currency' => $targetCurrency])
                ->order(['date' => 'DESC'])
                ->all();
        }

        $convert = function($amount, $dateStr) use ($targetCurrency, $ratesList) {
            if ($targetCurrency === 'USD') return (float)$amount;
            $applicableRate = 1.0;
            foreach ($ratesList as $r) {
                if ($r->date->format('Y-m-d') <= $dateStr) {
                    $applicableRate = (float)$r->rate_to_base;
                    break;
                }
            }
            return (float)$amount * $applicableRate;
        };

        $transactionsTable = $this->fetchTable('Transactions');
        
        // Find opening balance (cumulative before start_date)
        $openingTxns = $transactionsTable->find()
            ->where([
                'account_id' => $accountId,
                'date <' => $startDate
            ])
            ->all();

        $openingBalance = (float)($account->opening_balance ?? 0);
        $isNormalCredit = in_array($account->category, ['Liability', 'Equity', 'Revenue']);
        
        foreach ($openingTxns as $txn) {
            $amount = $convert((float)$txn->amount, $txn->date->format('Y-m-d'));
            $type = strtolower(trim((string)$txn->type));
            $isDebit = in_array($type, ['2', 'debit']);
            $isCredit = in_array($type, ['1', 'credit']);
            
            if ($isNormalCredit) {
                // If normal credit (Liab, Rev), Credits increase it, Debits decrease it
                $openingBalance += $isCredit ? $amount : -$amount;
            } else {
                // If normal debit (Asset, Exp), Debits increase it, Credits decrease it
                $openingBalance += $isDebit ? $amount : -$amount;
            }
        }

        // Current period transactions
        $transactions = $transactionsTable->find()
            ->where([
                'account_id' => $accountId,
                'date >=' => $startDate,
                'date <=' => $endDate
            ])
            ->order(['date' => 'ASC', 'id' => 'ASC'])
            ->all();

        $ledgerData = [];
        $runningBalance = $openingBalance;
        
        foreach ($transactions as $txn) {
            $amount = $convert((float)$txn->amount, $txn->date->format('Y-m-d'));
            $type = strtolower(trim((string)$txn->type));
            $isDebit = in_array($type, ['2', 'debit']);
            $isCredit = in_array($type, ['1', 'credit']);

            if ($isNormalCredit) {
                $runningBalance += $isCredit ? $amount : -$amount;
            } else {
                $runningBalance += $isDebit ? $amount : -$amount;
            }

            $ledgerData[] = [
                'txn' => $txn,
                'debit' => $isDebit ? $amount : 0,
                'credit' => $isCredit ? $amount : 0,
                'balance' => $runningBalance
            ];
        }

        $this->set(compact('account', 'startDate', 'endDate', 'targetCurrency', 'openingBalance', 'ledgerData'));
    }
}
