<?php
require 'config/paths.php';
require 'vendor/autoload.php';
$app = new \App\Application('config');
$app->bootstrap();
$table = \Cake\ORM\TableRegistry::getTableLocator()->get('Invoices');
$invoice = $table->find()->contain(['InvoiceItems'])->order(['id' => 'DESC'])->first();
echo json_encode($invoice->invoice_items);
