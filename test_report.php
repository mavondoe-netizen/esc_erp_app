<?php
$db = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
$sql = "SELECT a.name, a.type, a.subcategory, a.category, a.id as account_id,
               SUM(CASE WHEN t.date BETWEEN '2025-01-01' AND '2025-12-31' AND t.type IN ('Debit','1') THEN t.amount ELSE 0 END) as period_debits,
               SUM(CASE WHEN t.date BETWEEN '2025-01-01' AND '2025-12-31' AND t.type IN ('Credit','2') THEN t.amount ELSE 0 END) as period_credits,
               SUM(CASE WHEN t.date BETWEEN '2025-01-01' AND '2025-12-31' AND t.type IN ('Debit','1') THEN t.amount ELSE 0 END) as ytd_debits,
               SUM(CASE WHEN t.date BETWEEN '2025-01-01' AND '2025-12-31' AND t.type IN ('Credit','2') THEN t.amount ELSE 0 END) as ytd_credits
        FROM accounts a
        LEFT JOIN transactions t ON t.account_id = a.id
            AND t.company_id = 1
            AND t.date BETWEEN '2025-01-01' AND '2025-12-31'
        WHERE a.company_id = 1
            AND (
                a.type LIKE '%Income%' OR a.type LIKE '%Revenue%' OR a.type LIKE '%Expense%' OR a.type LIKE '%Cost%'
                OR a.category IN ('Income','Revenue','Expense','Cost of Sales','Cost')
            )
        GROUP BY a.id, a.name, a.type, a.subcategory, a.category
        ORDER BY a.type, a.subcategory, a.name";

$stmt = $db->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$report = ['Revenue' => [], 'CostOfSales' => [], 'Expenses' => []];
$totals = [];

foreach ($rows as $row) {
    if (abs((float)$row['period_credits'] - (float)$row['period_debits']) === 0.0) continue;
    $cat  = strtolower((string)$row['category']);
    $type = strtolower((string)$row['type']);
    $sub  = $row['subcategory'] ?: $row['category'] ?: 'General';
    
    $periodNet = (float)$row['period_credits'] - (float)$row['period_debits'];
    $isExpenseOrCost = (strpos($type, 'expense') !== false || strpos($type, 'cost') !== false || $cat === 'expense' || $cat === 'cost of sales');

    if ($isExpenseOrCost) {
        $periodNet = -$periodNet;
    }

    $entry = [
        'account_id' => $row['account_id'],
        'actual'     => $periodNet,
    ];

    if (strpos($type, 'income') !== false || strpos($type, 'revenue') !== false || $cat === 'revenue' || $cat === 'income') {
        $report['Revenue'][$sub][$row['name']] = $entry;
    } elseif (strpos($type, 'cost') !== false || $cat === 'cost of sales') {
        $report['CostOfSales'][$sub][$row['name']] = $entry;
    } else {
        $report['Expenses'][$sub][$row['name']] = $entry;
    }
}
print_r($report);
