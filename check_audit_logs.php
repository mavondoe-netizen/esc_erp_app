<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

use Cake\ORM\TableRegistry;

$AuditLogs = TableRegistry::getTableLocator()->get('AuditLogs');
$logs = $AuditLogs->find()->order(['id' => 'DESC'])->limit(10)->all();

echo "Last 10 Audit Logs:\n";
foreach ($logs as $log) {
    echo sprintf(
        "ID: %d | UserID: %s | CompanyID: %s | Action: %s | Model: %s | Created: %s\n",
        $log->id,
        $log->user_id ?? 'NULL',
        $log->company_id ?? 'NULL',
        $log->action,
        $log->model,
        $log->created
    );
}
