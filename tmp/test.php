<?php
require 'config/paths.php';
require 'vendor/autoload.php';
require 'config/bootstrap.php';

$locator = \Cake\ORM\TableRegistry::getTableLocator();
$earnings = $locator->get('Earnings');

// Check count
echo "Count: " . $earnings->find()->count() . "\n";

// Check list with named arguments
try {
    $list1 = $earnings->find('list', keyField: 'name', valueField: 'name')->toArray();
    echo "Named Args List: \n";
    print_r($list1);
} catch (\Exception $e) {
    echo "Named args failed: " . $e->getMessage() . "\n";
}

// Check list with array options
try {
    $list2 = $earnings->find('list', ['keyField' => 'name', 'valueField' => 'name'])->toArray();
    echo "Array Options List: \n";
    print_r($list2);
} catch (\Exception $e) {
    echo "Array options failed: " . $e->getMessage() . "\n";
}
