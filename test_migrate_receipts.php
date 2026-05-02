<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();
$db = \Cake\Datasource\ConnectionManager::get('default');

$cols = $db->execute('DESCRIBE receipts')->fetchAll('assoc');
$existing = array_column($cols, 'Field');

$migrations = [
    'customer_id'  => "ALTER TABLE receipts ADD COLUMN customer_id INT(11) NULL AFTER supplier_id",
    'date'         => "ALTER TABLE receipts ADD COLUMN date DATE NULL AFTER customer_id",
    'reference'    => "ALTER TABLE receipts ADD COLUMN reference VARCHAR(255) NULL AFTER date",
    'description'  => "ALTER TABLE receipts ADD COLUMN description TEXT NULL AFTER reference",
    'status'       => "ALTER TABLE receipts ADD COLUMN status VARCHAR(50) NOT NULL DEFAULT 'Draft' AFTER description",
    'company_id'   => "ALTER TABLE receipts ADD COLUMN company_id INT(11) NULL AFTER status",
];

foreach ($migrations as $col => $sql) {
    if (!in_array($col, $existing)) {
        $db->execute($sql);
        echo "Added column: $col\n";
    } else {
        echo "Column already exists: $col\n";
    }
}
echo "Migration complete.\n";
