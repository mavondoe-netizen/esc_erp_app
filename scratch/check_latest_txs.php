<?php
require 'config/paths.php';
require 'vendor/autoload.php';
require 'config/bootstrap.php';
use Cake\ORM\TableRegistry;

$txs = TableRegistry::getTableLocator()->get('Transactions')
    ->find()
    ->order(['id' => 'DESC'])
    ->limit(10)
    ->all();

echo "Latest Transactions:\n";
foreach ($txs as $t) {
    echo "ID: {$t->id}, Date: " . ($t->date ? $t->date->format('Y-m-d') : 'NULL') . ", Amount: {$t->amount}, ZWG: {$t->zwg}, Desc: {$t->description}\n";
}
