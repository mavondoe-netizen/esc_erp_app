<?php
require 'vendor/autoload.php';
require 'config/bootstrap.php';

use Cake\ORM\TableRegistry;

$Invoices = TableRegistry::getTableLocator()->get('Invoices');

// Force invoice 50 to Draft
$invoice = $Invoices->get(50, contain: ['InvoiceItems', 'Customers']);
$invoice->status = 'Draft';
$Invoices->save($invoice);
echo "Initial status set to: {$invoice->status}\n";

$data = [
    'date' => $invoice->date->format('Y-m-d'),
    'customer_id' => $invoice->customer->contact_id ?? 1,
    'currency' => $invoice->currency,
    'description' => $invoice->description,
    'status' => 'Sent',
    'total' => $invoice->total,
];

// simulate invoice_items
$itemsData = [];
foreach ($invoice->invoice_items as $i => $item) {
    $itemsData[$i] = [
        'id' => $item->id,
        'product_id' => $item->product_id,
        'account_id' => $item->account_id,
        'quantity' => $item->quantity,
        'unit_price' => $item->unit_price,
        'hs_code' => $item->hs_code,
        'vat_type' => $item->vat_type,
        'vat_rate' => $item->vat_rate,
        'vat_amount' => $item->vat_amount,
        'line_total' => $item->line_total,
    ];
}
$data['invoice_items'] = $itemsData;

$request = new \Cake\Http\ServerRequest([
    'url' => '/invoices/edit/' . $invoice->id,
    'post' => $data
]);
$request = $request->withMethod('POST');

// We need to set the identity so $user->get('company_id') works
$identity = new \Authentication\Identity\Identity([
    'id' => 1,
    'company_id' => $invoice->company_id,
]);
$request = $request->withAttribute('identity', $identity);
$request = $request->withAttribute('company_id', $invoice->company_id);

$controller = new \App\Controller\InvoicesController($request, null, 'Invoices');
$controller->edit($invoice->id);

$flash = $request->getSession()->read('Flash');
print_r($flash);

$invoiceAfter = $Invoices->get($invoice->id);
echo "Final status: {$invoiceAfter->status}\n";
