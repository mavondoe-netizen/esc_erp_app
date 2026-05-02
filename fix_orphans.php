<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

$db = \Cake\Datasource\ConnectionManager::get('default');

// 1. Find all payslips that are missing company_id and fix them from employees
echo "Fixing payslips...\n";
$payslips = $db->execute("
    UPDATE payslips p
    INNER JOIN employees e ON e.id = p.employee_id
    SET p.company_id = e.company_id
    WHERE (p.company_id IS NULL OR p.company_id = 0 OR p.company_id = '')
")->rowCount();
echo "Updated $payslips payslips.\n";

// 2. Find all payslip_items that are missing company_id and fix them from payslips
echo "Fixing payslip_items...\n";
$items = $db->execute("
    UPDATE payslip_items pi
    INNER JOIN payslips p ON p.id = pi.payslip_id
    SET pi.company_id = p.company_id
    WHERE (pi.company_id IS NULL OR pi.company_id = 0 OR pi.company_id = '')
      AND p.company_id IS NOT NULL AND p.company_id != 0 AND p.company_id != ''
")->rowCount();
echo "Updated $items payslip_items.\n";

// 3. Verify
$pCount = $db->execute("SELECT COUNT(*) as cnt FROM payslips WHERE company_id IS NULL OR company_id = 0 OR company_id = ''")->fetch('assoc')['cnt'];
$iCount = $db->execute("SELECT COUNT(*) as cnt FROM payslip_items WHERE company_id IS NULL OR company_id = 0 OR company_id = ''")->fetch('assoc')['cnt'];

echo "Final orphans: Payslips ($pCount), Items ($iCount)\n";

if ($iCount > 0) {
    echo "Sample orphan items:\n";
    $sample = $db->execute("SELECT pi.id, pi.payslip_id, pi.name, p.employee_id FROM payslip_items pi LEFT JOIN payslips p ON p.id = pi.payslip_id WHERE (pi.company_id IS NULL OR pi.company_id = 0 OR pi.company_id = '') LIMIT 5")->fetchAll('assoc');
    foreach ($sample as $s) print_r($s);
}
