<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;

$estimatesTable = TableRegistry::getTableLocator()->get('Estimates');
$estimate  = $estimatesTable->get(2, contain: ['EstimateItems']);

echo json_encode($estimate->estimate_items) . "\n";
