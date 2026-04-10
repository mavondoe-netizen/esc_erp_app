<?php
/**
 * Demo Data Seeder — Demo Company Limited
 * company_id = 199
 * Run via: php seed_demo.php
 */

define('COMPANY_ID', 199);
define('COMPANY_NAME', 'Demo Company Limited');

$pdo = new PDO('mysql:host=localhost;dbname=eras_app;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$now = date('Y-m-d H:i:s');

function run(PDO $pdo, string $sql, array $params = []): void {
    $pdo->prepare($sql)->execute($params);
}

function ins(PDO $pdo, string $table, array $data): int {
    $cols = implode('`, `', array_keys($data));
    $ph   = implode(', ', array_fill(0, count($data), '?'));
    $stmt = $pdo->prepare("INSERT INTO `$table` (`$cols`) VALUES ($ph)");
    $stmt->execute(array_values($data));
    return (int)$pdo->lastInsertId();
}

echo "=== Demo Seeder — " . COMPANY_NAME . " (company_id=" . COMPANY_ID . ") ===\n\n";

// ─── CLEAN EXISTING DEMO DATA ─────────────────────────────────────────────────
$cleanTables = [
    'zimra_reconciliations','payslips','pay_periods','employees','departments',
    'budgets','transactions','bank_transactions','invoices','deals','customers',
    'loans','loan_clients','loan_products','risks','assets','asset_depreciation',
    'asset_categories','asset_classifications','offices','exchange_rates','accounts','users','roles'
];
foreach ($cleanTables as $t) {
    try { run($pdo, "DELETE FROM `$t` WHERE company_id = ?", [COMPANY_ID]); }
    catch (Exception $e) { /* table may not have company_id */ }
}
run($pdo, "DELETE FROM companies WHERE id = ?", [COMPANY_ID]);
echo "🧹 Previous demo data cleaned\n";

// ─── 0. COMPANY ───────────────────────────────────────────────────────────────
ins($pdo, 'companies', [
    'id' => COMPANY_ID,
    'name' => COMPANY_NAME,
    'address' => '12 Demo Tower, Harare, Zimbabwe',
    'phone' => '+263 242 100 200',
    'email' => 'info@democompany.co.zw',
    'reporting_currency' => 'USD',
    'license_expiry_date' => '2030-12-31',
    'created' => $now,
    'modified' => $now
]);
echo "✅ Company seeded\n";

// ─── 0.1 ROLES & PERMISSIONS ──────────────────────────────────────────────────
$roleId = ins($pdo, 'roles', ['name' => 'administrator', 'created' => $now, 'company_id' => COMPANY_ID]);
echo "✅ Role 'administrator' seeded (Bypasses AppController guards)\n";

$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
$skipTables = ['phinxlog', 'roles_permissions', 'permissions']; // exclude some
foreach ($tables as $t) {
    if (in_array($t, $skipTables)) continue;
    
    // Convert table_name to CamelCase (Model name)
    $model = str_replace(' ', '', ucwords(str_replace('_', ' ', $t)));
    
    ins($pdo, 'permissions', [
        'role_id'     => $roleId,
        'company_id'  => COMPANY_ID,
        'model'       => $model,
        'can_read'    => 1,
        'can_create'  => 1,
        'can_update'  => 1,
        'can_delete'  => 1,
        'can_approve' => 1
    ]);
}
echo "✅ Full permissions seeded for role 'admin'\n";

// ─── 1. USER ─────────────────────────────────────────────────────────────────
ins($pdo, 'users', [
    'company_id' => COMPANY_ID,
    'email' => 'admin@democompany.co.zw',
    'password' => password_hash('demo@123', PASSWORD_BCRYPT),
    'role_id' => $roleId
]);
echo "✅ User seeded (email: admin@democompany.co.zw / pw: demo@123)\n";

// ─── 2. DEPARTMENTS ──────────────────────────────────────────────────────────
$deptNames = ['Finance & Accounts', 'Human Resources', 'Operations', 'ICT & Systems'];
$deptIds = [];
foreach ($deptNames as $d) {
    $deptIds[$d] = ins($pdo, 'departments', ['company_id' => COMPANY_ID, 'name' => $d, 'created' => $now, 'modified' => $now]);
}
echo "✅ " . count($deptNames) . " Departments seeded\n";

// ─── 3. ACCOUNTS (Chart of Accounts) ─────────────────────────────────────────
$accounts = [
    ['Cash at Hand',               'Asset',     'Cash & Bank',      null],
    ['FBC Bank USD Account',       'Asset',     'Cash & Bank',      null],
    ['CBZ Bank ZWG Account',       'Asset',     'Cash & Bank',      null],
    ['PAYE Payable',               'Liability', 'Tax Payables',     null],
    ['NSSA Payable',               'Liability', 'Tax Payables',     null],
    ['Accounts Payable',           'Liability', 'Trade Payables',   null],
    ['Share Capital',              'Equity',    'Capital',          null],
    ['Retained Earnings',          'Equity',    'Capital',          null],
    ['Revenue — Consulting Fees',  'Income',    'Revenue',          'Consulting'],
    ['Revenue — Software Licences','Income',    'Revenue',          'Software'],
    ['Revenue — ZWG Services',     'Income',    'Revenue',          'ZWG Services'],
    ['Salaries & Wages',           'Expense',   'Staff Costs',      null],
    ['NSSA Employer Contribution', 'Expense',   'Staff Costs',      null],
    ['Depreciation Expense',       'Expense',   'Non-Cash',         null],
    ['Office Rent',                'Expense',   'Occupancy',        null],
    ['Utilities',                  'Expense',   'Occupancy',        null],
    ['Fuel & Transport',           'Expense',   'Transport',        null],
    ['IT & Software',              'Expense',   'IT Costs',         null],
    ['Accumulated Depreciation',   'Asset',     'Fixed Assets',     null],
    ['Accounts Receivable',        'Asset',     'Trade Receivables',null],
];
$accountIds = [];
foreach ($accounts as [$name, $type, $category, $subcategory]) {
    $accountIds[$name] = ins($pdo, 'accounts', ['company_id' => COMPANY_ID, 'name' => $name, 'type' => $type, 'category' => $category, 'subcategory' => $subcategory]);
}
echo "✅ " . count($accounts) . " Accounts seeded\n";

// ─── 4. EXCHANGE RATES ───────────────────────────────────────────────────────
$rates = [
    ['2025-09-01', 25.50], ['2025-10-01', 26.10], ['2025-11-01', 26.80],
    ['2025-12-01', 27.50], ['2026-01-01', 28.20], ['2026-02-01', 28.90],
    ['2026-03-01', 29.40],
];
foreach ($rates as [$date, $rate]) {
    ins($pdo, 'exchange_rates', ['company_id' => COMPANY_ID, 'currency' => 'ZWG', 'rate_to_base' => $rate, 'date' => $date, 'created' => $now, 'modified' => $now]);
}
echo "✅ Exchange rates seeded\n";

// ─── 5. EMPLOYEES ─────────────────────────────────────────────────────────────
$employeeDefs = [
    ['E199-001', 'Tendai',    'Moyo',      'Finance Manager',        3200.00, 1985],
    ['E199-002', 'Rumbidzai', 'Chirwa',    'Senior Accountant',      2400.00, 1988],
    ['E199-003', 'Farai',     'Bhunu',     'HR Director',            3000.00, 1980],
    ['E199-004', 'Tapiwa',    'Sithole',   'HR Officer',             1800.00, 1992],
    ['E199-005', 'Chiedza',   'Makwenda',  'Operations Manager',     2800.00, 1983],
    ['E199-006', 'Blessing',  'Mutasa',    'Logistics Coordinator',  1600.00, 1994],
    ['E199-007', 'Takudzwa',  'Zvobgo',    'ICT Manager',            2900.00, 1987],
    ['E199-008', 'Memory',    'Chikowore', 'Systems Developer',      2200.00, 1990],
    ['E199-009', 'Simbarashe','Nkomo',     'Junior Accountant',      1400.00, 1996],
    ['E199-010', 'Rutendo',   'Mhango',    'Payroll Officer',        1600.00, 1993],
    ['E199-011', 'Tatenda',   'Hove',      'Field Officer',          1200.00, 1997],
    ['E199-012', 'Nyasha',    'Mapurisa',  'IT Support',             1500.00, 1995],
];
$employeeIds = [];
foreach ($employeeDefs as [$code, $first, $last, $desig, $salary, $dobYear]) {
    $employeeIds[$code] = ins($pdo, 'employees', [
        'company_id' => COMPANY_ID,
        'employee_code' => $code,
        'first_name' => $first,
        'last_name' => $last,
        'designation' => $desig,
        'basic_salary' => $salary,
        'date_of_birth' => "{$dobYear}-06-15",
        'nssa_number' => rand(1000000, 9999999),
        'tax_number' => rand(10000000, 99999999),
        'national_identity' => strtoupper(substr($first, 0, 2)) . rand(100000, 999999),
        'is_blind' => 0,
        'disabled' => 0,
        'usd_bank' => 'FBC Bank',
        'usd_account' => '0400' . rand(100000, 999999),
        'zwg_bank' => 'CBZ Bank',
        'zwg_account' => '0700' . rand(100000, 999999),
        'start_date' => '2022-01-01',
        'created' => $now,
        'modified' => $now
    ]);
}
echo "✅ " . count($employeeDefs) . " Employees seeded\n";

// ─── 6. PAY PERIODS ──────────────────────────────────────────────────────────
$periodDefs = [
    ['October 2025',  '2025-10-01', '2025-10-31', 'closed'],
    ['November 2025', '2025-11-01', '2025-11-30', 'closed'],
    ['December 2025', '2025-12-01', '2025-12-31', 'closed'],
    ['January 2026',  '2026-01-01', '2026-01-31', 'closed'],
    ['February 2026', '2026-02-01', '2026-02-28', 'closed'],
    ['March 2026',    '2026-03-01', '2026-03-31', 'open'],
];
$periodIds = [];
foreach ($periodDefs as [$name, $start, $end, $status]) {
    $periodIds[$name] = ins($pdo, 'pay_periods', ['company_id' => COMPANY_ID, 'name' => $name, 'start_date' => $start, 'end_date' => $end, 'status' => $status]);
}
echo "✅ " . count($periodDefs) . " Pay periods seeded\n";

// ─── 7. PAYSLIPS ─────────────────────────────────────────────────────────────
$exRate = 28.90;
$closedPeriods = array_slice($periodDefs, 0, 5);
$payslipCount = 0;
foreach ($closedPeriods as [$pName, $pStart, $pEnd]) {
    $pid = $periodIds[$pName];
    foreach ($employeeDefs as [$code, $first, $last, $desig, $salary]) {
        $eid = $employeeIds[$code];
        $nssa     = round(min($salary * 0.045, 700), 2);
        $taxable  = max(0, $salary - $nssa - 100);
        $paye     = round(max(0, ($taxable - 500) * 0.20), 2);
        $aidsLevy = round($paye * 0.03, 2);
        $totalTax = $paye + $aidsLevy;
        $deductions = $nssa + $totalTax;
        $net      = round($salary - $deductions, 2);
        ins($pdo, 'payslips', [
            'company_id' => COMPANY_ID,
            'employee_id' => $eid,
            'pay_period_id' => $pid,
            'basic_salary' => $salary,
            'gross_pay' => $salary,
            'nssa' => $nssa,
            'taxable_income' => $taxable,
            'paye' => $paye,
            'aids_levy' => $aidsLevy,
            'total_tax' => $totalTax,
            'deductions' => $deductions,
            'net_pay' => $net,
            'generated_date' => $pEnd,
            'exchange_rate' => $exRate,
            'usd_gross' => $salary,
            'usd_deductions' => $deductions,
            'usd_net' => $net,
            'zwg_gross' => round($salary * $exRate, 2),
            'zwg_deductions' => round($deductions * $exRate, 2),
            'zwg_net' => round($net * $exRate, 2)
        ]);
        $payslipCount++;
    }
}
echo "✅ {$payslipCount} Payslips seeded\n";

// ─── 8. ZIMRA RECONCILIATIONS ─────────────────────────────────────────────────
$zimraCount = 0;
foreach ($closedPeriods as [$pName, $pStart, $pEnd]) {
    $pid = $periodIds[$pName];
    foreach ($employeeDefs as [$code]) {
        $eid = $employeeIds[$code];
        $row = $pdo->query("SELECT total_tax FROM payslips WHERE company_id=" . COMPANY_ID . " AND employee_id={$eid} AND pay_period_id={$pid} LIMIT 1")->fetchColumn();
        if (!$row) continue;
        $assessed = round($row + rand(-200, 300) / 100, 2);
        $variance = round($assessed - $row, 2);
        $status   = abs($variance) < 0.01 ? 'cleared' : (rand(0, 3) === 0 ? 'cleared' : 'pending');
        ins($pdo, 'zimra_reconciliations', [
            'company_id' => COMPANY_ID,
            'employee_id' => $eid,
            'pay_period_id' => $pid,
            'payroll_tax_amount' => $row,
            'assessed_tax_amount' => $assessed,
            'variance' => $variance,
            'status' => $status,
            'cleared_date' => $status === 'cleared' ? $pEnd : null,
            'cleared_via' => $status === 'cleared' ? 'RCPT-ZIMRA-' . rand(1000, 9999) : null,
            'created' => $now,
            'modified' => $now
        ]);
        $zimraCount++;
    }
}
echo "✅ {$zimraCount} ZIMRA seeded\n";

// ─── 9. CUSTOMERS ────────────────────────────────────────────────────────────
$customerDefs = [
    ['Harare City Council',      'Rowan Martin Building, Harare'],
    ['TechSolutions Zimbabwe',   'Highlands, Harare'],
    ['MediCare Clinics',         'Avondale, Harare'],
    ['AgriTrade Holdings',       'Masvingo'],
    ['Rainbow Tourism Group',    'Elephant Hills Resort, Victoria Falls'],
    ['Zimnat Insurance',         'Eastgate, Harare'],
    ['SeedCo International',     'Westgate, Harare'],
    ['First Mutual Life',        'Jason Moyo, Harare'],
];
$customerIds = [];
foreach ($customerDefs as [$name, $address]) {
    $customerIds[] = ins($pdo, 'customers', ['company_id' => COMPANY_ID, 'name' => $name, 'address' => $address]);
}
echo "✅ " . count($customerDefs) . " Customers seeded\n";

// ─── 10. DEALS ────────────────────────────────────────────────────────────────
foreach ($customerIds as $idx => $cid) {
    ins($pdo, 'deals', [
        'company_id' => COMPANY_ID,
        'name' => "Deal " . ($idx+1),
        'value' => rand(5000, 100000),
        'stage' => 'Negotiation',
        'status' => 'open',
        'date' => date('Y-m-d'),
        'type' => 'Software',
        'contact_id' => $cid
    ]);
}
echo "✅ Deals seeded\n";

// ─── 11. INVOICES ─────────────────────────────────────────────────────────────
// invoices: id, date, customer_id, currency, description, status, total, company_id, department_id
foreach ($customerIds as $idx => $cid) {
    run($pdo, "INSERT INTO invoices (company_id, customer_id, date, currency, description, total, status) VALUES (?,?,?,?,?,?,?)",
        [COMPANY_ID, $cid, date('Y-m-d'), 'USD', 'Service Invoice ' . ($idx+1), rand(1000, 5000), 'unpaid']);
}
echo "✅ Invoices seeded\n";

// ─── 12. BANK TRANSACTIONS ────────────────────────────────────────────────────
// bank_transactions: id, company_id, bank_account_id, date, description, amount, reference, reconciled, transaction_id, created, modified
$fbcAccId = $accountIds['FBC Bank USD Account'];
run($pdo, "INSERT INTO bank_transactions
    (company_id, bank_account_id, date, description, amount, reference, reconciled, created, modified)
    VALUES (?,?,?,?,?,?,0,?,?)",
    [COMPANY_ID, $fbcAccId, date('Y-m-d'), 'Test deposit', 500.00, 'REF-DEMO', $now, $now]);
echo "✅ Bank transaction seeded\n";

// ─── 13. LEDGER TRANSACTIONS ──────────────────────────────────────────────────
// transactions: id, bank_transaction_id, date, description, currency, amount, zwg, type, account_id, company_id
run($pdo, "INSERT INTO transactions
    (company_id, account_id, date, description, currency, amount, zwg, type)
    VALUES (?,?,?,?,?,?,?,?)",
    [COMPANY_ID, $fbcAccId, date('Y-m-d'), 'Initial capital', 'USD', 1000.00, 28900.00, 'Credit']);
echo "✅ Ledger transaction seeded\n";

// ─── 14. ASSETS ─────────────────────────────────────────────────────────────
// assets: id, company_id, asset_tag, description, category_id, classification_id, acquisition_date, acquisition_cost, useful_life, depreciation_method, residual_value, current_book_value, status, office_id, assigned_to, created, modified
run($pdo, "INSERT INTO asset_categories (company_id, name, created, modified) VALUES (?,?,?,?)", [COMPANY_ID, 'Vehicles', $now, $now]);
$catId = (int)$pdo->lastInsertId();
run($pdo, "INSERT INTO offices (company_id, name, location, created, modified) VALUES (?,?,?,?,?)", [COMPANY_ID, 'Head Office', 'Harare', $now, $now]);
$officeId = (int)$pdo->lastInsertId();

run($pdo, "INSERT INTO assets (company_id, asset_tag, description, category_id, acquisition_date, acquisition_cost, useful_life, depreciation_method, residual_value, status, office_id, created, modified)
           VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)",
    [COMPANY_ID, 'AST-199-001', 'Demo Vehicle', $catId, '2023-01-01', 25000.00, 60, 'straight_line', 5000.00, 'active', $officeId, $now, $now]);
echo "✅ Asset seeded\n";

// ─── 15. RISKS ───────────────────────────────────────────────────────────────
run($pdo, "INSERT INTO risks (company_id, title, description, status, created, modified) VALUES (?,?,?,?,?,?)",
    [COMPANY_ID, 'Sample Risk', 'A demo risk description', 'open', $now, $now]);
echo "✅ Risk seeded\n";

// ─── 16. LOAN PRODUCTS ────────────────────────────────────────────────────────
run($pdo, "INSERT INTO loan_products (company_id, name, code, created, modified) VALUES (?,?,?,?,?)",
    [COMPANY_ID, 'Staff Loan', 'SL199', $now, $now]);
$lpId = (int)$pdo->lastInsertId();
echo "✅ Loan product seeded\n";

// ─── 17. LOAN CLIENTS ─────────────────────────────────────────────────────────
run($pdo, "INSERT INTO loan_clients (company_id, name, created, modified) VALUES (?,?,?,?)",
    [COMPANY_ID, 'John Doe', $now, $now]);
$lcId = (int)$pdo->lastInsertId();
echo "✅ Loan client seeded\n";

// ─── 18. LOANS ────────────────────────────────────────────────────────────────
run($pdo, "INSERT INTO loans (company_id, client_id, loan_product_id, principal, status, created, modified) VALUES (?,?,?,?,?,?,?)",
    [COMPANY_ID, $lcId, $lpId, 1000.00, 'active', $now, $now]);
echo "✅ Loan seeded\n";

// ─── 19. BUDGETS ─────────────────────────────────────────────────────────────
run($pdo, "INSERT INTO budgets (company_id, account_id, amount, start_date, end_date, created, modified) VALUES (?,?,?,?,?,?,?)",
    [COMPANY_ID, $fbcAccId, 5000.00, '2026-01-01', '2026-12-31', $now, $now]);
echo "✅ Budget seeded\n";

echo "\n========================================\n";
echo "ALL DEMO DATA SEEDED SUCCESSFULLY!\n";
echo "========================================\n";
