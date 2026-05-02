<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

$db = \Cake\Datasource\ConnectionManager::get('default');

$p = $db->execute("SELECT * FROM payslips ORDER BY id DESC LIMIT 1")->fetch('assoc');
if ($p) {
    echo "Latest Payslip:\n";
    print_r($p);
    
    $items = $db->execute("SELECT * FROM payslip_items WHERE payslip_id = {$p['id']}")->fetchAll('assoc');
    echo "Items Count: " . count($items) . "\n";
    if (count($items) > 0) {
        foreach ($items as $item) {
            echo " - {$item['name']}: {$item['amount']} ({$item['currency']})\n";
        }
    } else {
        echo "No items found for this payslip.\n";
    }
} else {
    echo "No payslips found in the database.\n";
}
