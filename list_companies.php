<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

use Cake\ORM\TableRegistry;

$Companies = TableRegistry::getTableLocator()->get('Companies');
$companies = $Companies->find()->all();
foreach($companies as $c) {
    echo "ID: " . $c->id . " - " . $c->name . "\n";
}
