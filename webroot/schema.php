<?php
$pdo = new PDO('mysql:host=localhost;dbname=eras_app', 'root', '');
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
        $pdo->exec($q);
        echo "Success: $q\n";
    } catch (\Exception $e) {
        echo "Failed: $q - " . $e->getMessage() . "\n";
    }
}
echo "Schema updates done.\n";
