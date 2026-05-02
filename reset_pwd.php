<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

use Cake\ORM\TableRegistry;
use Authentication\PasswordHasher\DefaultPasswordHasher;

$Users = TableRegistry::getTableLocator()->get('Users');
$user = $Users->find()->where(['email' => 'admin@democompany.co.zw'])->first();

if ($user) {
    $hasher = new DefaultPasswordHasher();
    $user->password = $hasher->hash('password123');
    if ($Users->save($user)) {
        echo "Password reset successfully for admin@democompany.co.zw\n";
    } else {
        echo "Failed to reset password.\n";
    }
} else {
    echo "User not found.\n";
}
