<?php
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

use Cake\ORM\TableRegistry;

$companiesTable = TableRegistry::getTableLocator()->get('Companies');
$accountsTable = TableRegistry::getTableLocator()->get('Accounts');

$companies = $companiesTable->find()->all();

foreach ($companies as $company) {
    $exists = $accountsTable->find()
        ->where([
            'company_id' => $company->id,
            'name' => 'Suspense Account'
        ])
        ->first();

    if (!$exists) {
        $account = $accountsTable->newEntity([
            'company_id' => $company->id,
            'name' => 'Suspense Account',
            'category' => 'Equity',
            'type' => '1', // Credit
            'subcategory' => 'Opening Balance Offset'
        ]);
        if ($accountsTable->save($account)) {
            echo "Created Suspense Account for company ID {$company->id}\n";
        } else {
            echo "Failed to create Suspense Account for company ID {$company->id}\n";
            print_r($account->getErrors());
        }
    } else {
        echo "Suspense Account already exists for company ID {$company->id}\n";
    }
}
echo "Done.\n";
