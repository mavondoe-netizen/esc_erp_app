<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

use Cake\ORM\TableRegistry;

$Users = TableRegistry::getTableLocator()->get('Users');
$user = $Users->find()->where(['company_id' => 199])->first();

if ($user) {
    echo "User ID: " . $user->id . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role ID: " . $user->role_id . "\n";
    echo "Company ID: " . $user->company_id . "\n";
} else {
    echo "No users found for company 199.\n";
}
