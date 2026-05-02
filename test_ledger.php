<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();

$Invoices = \Cake\ORM\TableRegistry::getTableLocator()->get('Invoices');
$Transactions = \Cake\ORM\TableRegistry::getTableLocator()->get('Transactions');

// get the last approved invoice
$invoice = $Invoices->find()->where(['status' => 'Approved'])->order(['id' => 'DESC'])->first();

if (!$invoice) {
    echo "No approved invoice found.\n";
    exit;
}

echo "Found Invoice ID: {$invoice->id}, Company ID: {$invoice->company_id}\n";

// check if there are transactions for this invoice
$txs = $Transactions->find()->where(['invoice_id' => $invoice->id])->all();
echo "Existing Transactions: " . $txs->count() . "\n";

// run postToLedger explicitly
echo "Running postToLedger...\n";
$Invoices->postToLedger($invoice, $invoice->company_id);

$txsAfter = $Transactions->find()->where(['invoice_id' => $invoice->id])->all();
echo "Transactions after run: " . $txsAfter->count() . "\n";

// if still 0, debug the AR account
$Accounts = \Cake\ORM\TableRegistry::getTableLocator()->get('Accounts');
$arAccount = $Accounts->find()
    ->where(['Accounts.company_id' => $invoice->company_id, 'Accounts.category LIKE' => '%Receivable%'])
    ->first();

if (!$arAccount) {
    echo "ERROR: No Accounts Receivable account found for company {$invoice->company_id}\n";
    
    // what accounts do exist?
    $all = $Accounts->find()->where(['company_id' => $invoice->company_id])->all();
    echo "Available accounts:\n";
    foreach ($all as $a) {
        echo "- {$a->id}: {$a->name} (Cat: {$a->category})\n";
    }
} else {
    echo "Found AR Account: {$arAccount->id} ({$arAccount->name})\n";
}
