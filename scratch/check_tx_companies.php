<?php
require 'config/paths.php';
require 'vendor/autoload.php';
require 'config/bootstrap.php';
use Cake\ORM\TableRegistry;

$txs = TableRegistry::getTableLocator()->get('Transactions')
    ->find()
    ->where(['id >=' => 1609])
    ->limit(25)
    ->all();

echo "Transactions from 1609:\n";
foreach ($txs as $t) {
    echo "ID: {$t->id}, Company: {$t->company_id}, Date: " . ($t->date ? $t->date->format('Y-m-d') : 'NULL') . ", Amount: {$t->amount}, ZWG: {$t->zwg}, Desc: {$t->description}\n";
}
