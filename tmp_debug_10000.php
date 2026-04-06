<?php
// Script to debug payslip items and find the 10000zwg source
use Cake\ORM\TableRegistry;

require 'config/bootstrap.php';

$items = TableRegistry::getTableLocator()->get('PayslipItems')->find()
    ->where(['amount' => 10000])
    ->all();

echo "Found " . count($items) . " items with amount 10000\n";
foreach ($items as $item) {
    echo "Item ID: {$item->id}, Name: {$item->name}, Payslip ID: {$item->payslip_id}\n";
}

$employees = TableRegistry::getTableLocator()->get('Employees')->find()
    ->where(['basic_salary' => 10000])
    ->all();

echo "Found " . count($employees) . " employees with basic_salary 10000\n";
foreach ($employees as $emp) {
    echo "Employee ID: {$emp->id}, Code: {$emp->employee_code}\n";
}
