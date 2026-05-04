<?php
require 'config/paths.php';
require 'vendor/autoload.php';
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

require 'config/bootstrap.php';

$connection = ConnectionManager::get('default');
$schema = $connection->getSchemaCollection()->describe('sch_students');
print_r($schema->columns());
