<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();
$db = \Cake\Datasource\ConnectionManager::get('default');
echo "COMPANIES:\n";
print_r($db->getSchemaCollection()->describe('companies')->columns());
echo "\nCUSTOMERS:\n";
print_r($db->getSchemaCollection()->describe('customers')->columns());
echo "\nINVOICES:\n";
print_r($db->getSchemaCollection()->describe('invoices')->columns());
