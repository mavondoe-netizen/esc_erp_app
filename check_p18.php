<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

$db = \Cake\Datasource\ConnectionManager::get('default');

$p = $db->execute("SELECT * FROM payslips WHERE id = 18")->fetch('assoc');
if ($p) {
    echo "Payslip 18 exists:\n";
    print_r($p);
} else {
    echo "Payslip 18 does NOT exist.\n";
}

$itemsCount = $db->execute("SELECT COUNT(*) as cnt FROM payslip_items WHERE payslip_id = 18")->fetch('assoc')['cnt'];
echo "Items for payslip 18: $itemsCount\n";
