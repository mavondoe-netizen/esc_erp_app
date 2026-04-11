<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;
use Authentication\PasswordHasher\DefaultPasswordHasher;

$usersTable = TableRegistry::getTableLocator()->get('Users');
$user = $usersTable->get(14);

$hasher = new DefaultPasswordHasher();
$user->password = $hasher->hash('Admin123!');

if ($usersTable->save($user)) {
    echo "Password for admin@democompany.co.zw (ID 14) has been reset to: Admin123!\n";
} else {
    echo "Failed to reset password.\n";
}
