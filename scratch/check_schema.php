<?php
require 'vendor/autoload.php';
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use App\Application;

$connection = ConnectionManager::get('default');
$columns = $connection->getSchemaCollection()->describe('companies')->columns();
echo implode(', ', $columns);
