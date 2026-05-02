<?php
require 'config/paths.php';
require 'vendor/autoload.php';

use Cake\Datasource\ConnectionManager;
use App\Application;

$app = new Application('config');
$app->bootstrap();

$db = ConnectionManager::get('default');
$res = $db->execute('DESCRIBE companies')->fetchAll('assoc');
print_r($res);
