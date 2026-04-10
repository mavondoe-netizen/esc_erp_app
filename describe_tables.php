<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$tables = [
    'companies', 'users', 'departments', 'accounts', 'exchange_rates', 'employees',
    'pay_periods', 'payslips', 'zimra_reconciliations', 'customers', 'deals',
    'invoices', 'bank_transactions', 'transactions', 'offices', 
    'asset_categories', 'asset_classifications', 'assets', 'risks', 
    'loan_products', 'loan_clients', 'loans', 'budgets', 'roles'
];
foreach ($tables as $t) {
    try {
        $cols = $pdo->query("DESCRIBE `$t`")->fetchAll(PDO::FETCH_COLUMN);
        echo "$t: " . implode(', ', $cols) . "\n";
    } catch (Exception $e) {
        echo "$t: ERROR\n";
    }
}
