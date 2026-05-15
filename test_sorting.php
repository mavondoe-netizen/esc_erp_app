<?php
require 'config/paths.php';
require 'vendor/autoload.php';
require 'config/bootstrap.php';
use Cake\ORM\TableRegistry;
$t1 = TableRegistry::getTableLocator()->get('Transactions')->find()->order(['id' => 'DESC'])->limit(10)->select(['id', 'date', 'created'])->toArray();
$t2 = TableRegistry::getTableLocator()->get('Transactions')->find()->order(['date' => 'DESC', 'id' => 'DESC'])->limit(10)->select(['id', 'date', 'created'])->toArray();
echo "Latest by ID:\n";
foreach($t1 as $t) { echo "ID: {$t->id}, Date: {$t->date->format('Y-m-d')}\n"; }
echo "\nLatest by Date (how index sorts):\n";
foreach($t2 as $t) { echo "ID: {$t->id}, Date: {$t->date->format('Y-m-d')}\n"; }
