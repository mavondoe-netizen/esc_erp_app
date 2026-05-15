<?php
require 'config/paths.php';
require 'vendor/autoload.php';
require 'config/bootstrap.php';
use Cake\ORM\TableRegistry;

$schema = TableRegistry::getTableLocator()->get('Receipts')->getSchema();
print_r($schema->columns());
