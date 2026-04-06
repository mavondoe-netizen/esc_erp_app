<?php
require 'vendor/autoload.php';
require 'config/paths.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

Configure::write('Tenant.company_id', 1);

$Accounts = TableRegistry::getTableLocator()->get('Accounts');
$account = $Accounts->newEntity([
    'name' => 'Test Account ' . time(),
    'category' => 'Asset',
    'type' => 'Fixed Asset',
    'subcategory' => 'Fixed Assets',
]);

// Since user is needed for audit log, but user_id allows empty.
// What about AuditLog save failing? Let's check!
try {
    if (!$Accounts->save($account)) {
        echo "Account failed: ";
        print_r($account->getErrors());
    } else {
        echo "Account saved successfully.";
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";

    // check audit logs table latest entity errors
    $AuditLogs = TableRegistry::getTableLocator()->get('AuditLogs');
    echo "\nAuditLogs behavior might have failed. Checking latest errors if any...\n";
    // Not easy to get the transient log entity. Let's just create an AuditLog manually to find the validation bug
    $log = $AuditLogs->newEmptyEntity();
    $log->set([
        'user_id' => 1,
        'model' => 'Accounts',
        'record_id' => '1',
        'action' => 'CREATE',
        'changed_data' => '{"name":"Test"}'
    ]);
    if (!$AuditLogs->save($log)) {
        echo "\nAuditLog save failed! Errors:\n";
        print_r($log->getErrors());
    } else {
        echo "\nAuditLog saved fine, but account save threw an exception.";
    }
}
