<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;

$conn = TableRegistry::getTableLocator()->get('Transactions')->getConnection();
$companyId = 1;
$startDate = '2025-01-01';
$endDate = '2025-12-31';
$ytdStart = '2025-01-01';
$balanceField = 't.amount';

$sql = "SELECT a.name, a.type, a.subcategory, a.category, a.id as account_id,
               SUM(CASE WHEN t.date BETWEEN :start AND :end AND t.type IN ('Debit','1') THEN $balanceField ELSE 0 END) as period_debits,
               SUM(CASE WHEN t.date BETWEEN :start AND :end AND t.type IN ('Credit','2') THEN $balanceField ELSE 0 END) as period_credits,
               SUM(CASE WHEN t.date BETWEEN :ytd AND :end AND t.type IN ('Debit','1') THEN $balanceField ELSE 0 END) as ytd_debits,
               SUM(CASE WHEN t.date BETWEEN :ytd AND :end AND t.type IN ('Credit','2') THEN $balanceField ELSE 0 END) as ytd_credits
        FROM accounts a
        LEFT JOIN transactions t ON t.account_id = a.id
            AND t.company_id = :cid
            AND t.date BETWEEN :ytd AND :end
        WHERE a.company_id = :cid2
            AND (
                a.type LIKE '%Income%' OR a.type LIKE '%Revenue%' OR a.type LIKE '%Expense%' OR a.type LIKE '%Cost%'
                OR a.category IN ('Income','Revenue','Expense','Cost of Sales','Cost')
            )
        GROUP BY a.id, a.name, a.type, a.subcategory, a.category
        ORDER BY a.type, a.subcategory, a.name";

$stmt = $conn->execute($sql, [
    ':cid' => $companyId, ':cid2' => $companyId, 
    ':start' => $startDate, ':end' => $endDate, ':ytd' => $ytdStart
]);
$rows = $stmt->fetchAll('assoc');

$valid = [];
foreach($rows as $row) {
    if (abs($row['period_credits'] - $row['period_debits']) > 0 || abs($row['ytd_credits'] - $row['ytd_debits']) > 0) {
        $valid[] = $row;
    }
}
echo "Total Rows: " . count($rows) . "\n";
echo "Valid Evaluated Rows: " . count($valid) . "\n";
print_r($valid);
