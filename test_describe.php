<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();
$db = \Cake\Datasource\ConnectionManager::get('default');

echo "=== receipts columns ===\n";
$s = $db->execute('DESCRIBE receipts')->fetchAll('assoc');
foreach ($s as $r) echo $r['Field'] . ' (' . $r['Type'] . ")\n";

echo "\n=== companies columns ===\n";
$s = $db->execute('DESCRIBE companies')->fetchAll('assoc');
foreach ($s as $r) echo $r['Field'] . ' (' . $r['Type'] . ")\n";
