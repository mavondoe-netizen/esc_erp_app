<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

$db = \Cake\Datasource\ConnectionManager::get('default');

// Check actual integer value stored
$sample = $db->execute("SELECT id, payslip_id, CAST(company_id AS SIGNED) as company_id_int FROM payslip_items LIMIT 5")->fetchAll('assoc');
echo "=== actual int values ===\n";
foreach ($sample as $r) print_r($r);

// Check payslips too
$psample = $db->execute("SELECT id, CAST(company_id AS SIGNED) as cid_int, employee_id FROM payslips WHERE id = 18")->fetchAll('assoc');
echo "=== payslip 18 ===\n";
foreach ($psample as $r) print_r($r);

// Try updating items where company_id cast to int = 0, join payslip
$r1 = $db->execute("
    UPDATE payslip_items pi
    INNER JOIN payslips p ON p.id = pi.payslip_id
    SET pi.company_id = p.company_id
    WHERE CAST(pi.company_id AS SIGNED) = 0 AND CAST(p.company_id AS SIGNED) > 0
")->rowCount();
echo "Step1 (items from payslips): Updated $r1\n";

// Now fix payslips that have company_id=0 via employees
$r2 = $db->execute("
    UPDATE payslips p
    INNER JOIN employees e ON e.id = p.employee_id
    SET p.company_id = e.company_id
    WHERE CAST(p.company_id AS SIGNED) = 0 AND CAST(e.company_id AS SIGNED) > 0
")->rowCount();
echo "Step2 (payslips from employees): Updated $r2\n";

// Cascade again after fixing payslips
$r3 = $db->execute("
    UPDATE payslip_items pi
    INNER JOIN payslips p ON p.id = pi.payslip_id
    SET pi.company_id = p.company_id
    WHERE CAST(pi.company_id AS SIGNED) = 0 AND CAST(p.company_id AS SIGNED) > 0
")->rowCount();
echo "Step3 (items after payslip fix): Updated $r3\n";

$final = $db->execute("SELECT COUNT(*) as cnt FROM payslip_items WHERE CAST(company_id AS SIGNED) = 0")->fetch('assoc');
echo "Remaining zero company_id items: {$final['cnt']}\n";

$sample2 = $db->execute("SELECT id, payslip_id, CAST(company_id AS SIGNED) as cid FROM payslip_items LIMIT 5")->fetchAll('assoc');
echo "Verification:\n";
foreach ($sample2 as $r) print_r($r);
