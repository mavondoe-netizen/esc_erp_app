<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;

$rolesTable = TableRegistry::getTableLocator()->get('Roles');
$roles = $rolesTable->find()->all();

echo "ROLES:\n";
foreach ($roles as $role) {
    echo "ID: " . $role->id . " | Name: " . $role->name . "\n";
}

$usersTable = TableRegistry::getTableLocator()->get('Users');
$users = $usersTable->find()->all();

echo "\nUSERS:\n";
foreach ($users as $user) {
    echo "ID: " . $user->id . " | Email: " . $user->email . " | Role ID: " . $user->role_id . "\n";
}
