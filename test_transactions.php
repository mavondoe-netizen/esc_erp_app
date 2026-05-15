<?php
require 'config/paths.php';
require 'vendor/autoload.php';
require 'config/bootstrap.php';
use Cake\ORM\TableRegistry;
$t = TableRegistry::getTableLocator()->get('Transactions')->find()->where(['id >=' => 1609])->toArray();
print_r($t);
