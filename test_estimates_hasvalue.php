<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;

$estimatesTable = TableRegistry::getTableLocator()->get('Estimates');

$estimate = $estimatesTable->find()
    ->contain(['Customers', 'EstimateItems' => ['Accounts', 'Products']])
    ->first();

foreach ($estimate->estimate_items as $item) {
    echo "Item ID: " . $item->id . "\n";
    echo "  product_id: " . var_export($item->product_id, true) . "\n";
    echo "  product object set: " . var_export(isset($item->product), true) . "\n";
    echo "  hasValue('product'): " . var_export($item->hasValue('product'), true) . "\n";
    echo "  product name: " . ($item->hasValue('product') ? $item->product->name : 'N/A') . "\n";
}
