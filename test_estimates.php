<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;

$estimatesTable = TableRegistry::getTableLocator()->get('Estimates');

$estimate = $estimatesTable->find()
    ->contain(['Customers', 'EstimateItems' => ['Accounts', 'Products']])
    ->first();

echo "### ESTIMATE:\n";
print_r($estimate->toArray());
