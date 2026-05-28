<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;

$estimatesTable = TableRegistry::getTableLocator()->get('Estimates');

$estimate = $estimatesTable->find()
    ->where(['Estimates.id' => 2])
    ->contain(['Customers', 'EstimateItems' => ['Accounts', 'Products']])
    ->first();

echo "### ESTIMATE 2:\n";
print_r($estimate->toArray());
