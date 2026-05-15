<?php
require dirname(__DIR__) . '/config/paths.php';
require dirname(__DIR__) . '/vendor/autoload.php';
use Cake\Datasource\ConnectionManager;
$c = require dirname(__DIR__) . '/config/app.php';
ConnectionManager::setConfig('default', $c['Datasources']['default']);
$db = ConnectionManager::get('default');

$queries = [
    'ALTER TABLE deals ADD COLUMN probability INT DEFAULT 0',
    'ALTER TABLE deals ADD COLUMN expected_close_date DATE NULL',
    'ALTER TABLE tasks ADD COLUMN deal_id INT NULL',
    'ALTER TABLE estimates ADD COLUMN deal_id INT NULL',
    'ALTER TABLE contracts ADD COLUMN deal_id INT NULL',
    'ALTER TABLE contracts ADD COLUMN is_signed BOOLEAN DEFAULT FALSE',
    'ALTER TABLE contracts ADD COLUMN signature_date DATE NULL'
];

foreach ($queries as $q) {
    try {
        $db->execute($q);
        echo "Success: $q\n";
    } catch (\Exception $e) {
        echo "Failed: $q - " . $e->getMessage() . "\n";
    }
}
echo "Schema updates done.\n";
