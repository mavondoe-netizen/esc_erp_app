<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 * @var \App\Model\Entity\Company $company
 */

$currencyCode = $invoice->currency ?? 'USD';
$currencySymbols = [
    'USD' => '$',
    'EUR' => '€',
    'GBP' => '£',
    'ZWG' => 'ZiG',
    'ZAR' => 'R',
    'CAD' => 'C$',
    'AUD' => 'A$',
];
$currencySymbol = $currencySymbols[$currencyCode] ?? $currencyCode;

$totalPaid = 0;
if (!empty($invoice->receipts)) {
    foreach ($invoice->receipts as $receipt) {
        if ($receipt->status === 'Approved') {
            $totalPaid += (float)$receipt->amount;
        }
    }
}
$balanceDue = max(0.0, (float)$invoice->total - $totalPaid);

$this->assign('actions', $this->element('document_actions', [
    'entity' => $invoice,
    'controller' => 'Invoices',
    'approval_workflow' => true
]));
?>
<div class="invoices view content">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; border-bottom: 2px solid #f1f5f9; padding-bottom: 30px;">
        <div>
            <?php if ($company->logo): ?>
                <img src="<?= h($company->logo) ?>" style="max-height: 100px; margin-bottom: 15px;" alt="Logo" />
            <?php else: ?>
                <h1 style="color: var(--primary-color); margin: 0;"><?= h($company->name) ?></h1>
            <?php endif; ?>
            <p style="color: #64748b; line-height: 1.6; margin: 0;">
                <?= nl2br(h($company->address)) ?><br>
                <strong>Email:</strong> <?= h($company->email) ?><br>
                <strong>Phone:</strong> <?= h($company->phone) ?>
                <?php if ($company->tin): ?><br><strong>TIN:</strong> <?= h($company->tin) ?><?php endif; ?>
                <?php if ($company->vat_number): ?><br><strong>VAT No:</strong> <?= h($company->vat_number) ?><?php endif; ?>
            </p>
        </div>
        <div style="text-align: right;">
            <h1 style="font-size: 2.5rem; letter-spacing: -0.02em; color: #0f172a; margin-bottom: 10px;">INVOICE</h1>
            <div style="color: #64748b;">
                <strong>Invoice #:</strong> <span style="color: #0f172a;"><?= h($invoice->id) ?></span><br>
                <?php if ($invoice->manual_reference): ?>
                    <strong>Reference:</strong> <span style="color: #0f172a;"><?= h($invoice->manual_reference) ?></span><br>
                <?php endif; ?>
                <strong>Date:</strong> <span style="color: #0f172a;"><?= h($invoice->date) ?></span><br>
                <strong>Status:</strong> <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 20px; color: #0f172a; font-weight: 600; font-size: 0.8rem;"><?= strtoupper(h($invoice->status)) ?></span>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
        <div>
            <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Bill To</h4>
            <h3 style="margin-bottom: 5px;"><?= $invoice->hasValue('customer') ? h($invoice->customer->name) : '—' ?></h3>
            <p style="color: #64748b; line-height: 1.5;">
                <?= h($invoice->description) ?>
                <?php if ($invoice->hasValue('customer') && $invoice->customer->tin): ?><br><strong>TIN:</strong> <?= h($invoice->customer->tin) ?><?php endif; ?>
                <?php if ($invoice->hasValue('customer') && $invoice->customer->vat_number): ?><br><strong>VAT No:</strong> <?= h($invoice->customer->vat_number) ?><?php endif; ?>
            </p>
        </div>
        <div style="text-align: right;">
             <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Currency</h4>
             <h3 style="color: var(--primary-color); font-weight: 600;"><?= h($currencyCode) ?> (<?= h($currencySymbol) ?>)</h3>
        </div>
    </div>

    <div class="related">
        <table class="table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="text-center" style="width: 80px;">Qty</th>
                    <th class="text-right" style="width: 120px;">Unit Price</th>
                    <th class="text-right" style="width: 100px;">Tax (VAT)</th>
                    <th class="text-right" style="width: 130px;">Line Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $subtotal = 0;
                $totalVat = 0;
                foreach ($invoice->invoice_items as $item) : 
                    $vatAmount = $item->vat_amount ?? 0;
                    $basePrice = $item->quantity * $item->unit_price;
                    $subtotal += $basePrice;
                    $totalVat += $vatAmount;
                ?>
                <tr>
                    <td>
                        <strong style="color: #0f172a;"><?= $item->hasValue('product') ? h($item->product->name) : 'Custom Item' ?></strong><br>
                        <small style="color: #64748b;"><?= h($item->description) ?></small>
                    </td>
                    <td class="text-center"><?= $this->Number->format($item->quantity) ?></td>
                    <td class="text-right"><?= $this->formatCurrency($item->unit_price, $currencyCode) ?></td>
                    <td class="text-right">
                        <span style="display: block; font-size: 0.75rem; color: #94a3b8;"><?= $this->Number->format($item->vat_rate) ?>%</span>
                        <?= $this->formatCurrency($item->vat_amount, $currencyCode) ?>
                    </td>
                    <td class="text-right" style="font-weight: 600; color: #0f172a;"><?= $this->formatCurrency($item->line_total, $currencyCode) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="display: flex; justify-content: flex-end; margin-top: 30px; align-items: flex-end;">
            <?php
            try {
                $qrData = sprintf(
                    "Supplier: %s\nTIN: %s\nVAT No: %s\nInvoice #: %s\nDate: %s\nBill To: %s\nCustomer TIN: %s\nCustomer VAT: %s\nSubtotal: %s\nVAT Total: %s\nGrand Total: %s",
                    $company->name,
                    $company->tin ?? 'N/A',
                    $company->vat_number ?? 'N/A',
                    $invoice->id,
                    $invoice->date,
                    $invoice->hasValue('customer') ? $invoice->customer->name : 'N/A',
                    ($invoice->hasValue('customer') && $invoice->customer->tin) ? $invoice->customer->tin : 'N/A',
                    ($invoice->hasValue('customer') && $invoice->customer->vat_number) ? $invoice->customer->vat_number : 'N/A',
                    $this->formatCurrency($subtotal, $currencyCode),
                    $this->formatCurrency($totalVat, $currencyCode),
                    $this->formatCurrency($invoice->total, $currencyCode)
                );

                $qrOptions = new \chillerlan\QRCode\QROptions([
                    'version'      => \chillerlan\QRCode\Common\Version::AUTO,
                    'outputType'   => \chillerlan\QRCode\Output\QRMarkupSVG::class,
                    'eccLevel'     => \chillerlan\QRCode\Common\EccLevel::M,
                    'addQuietzone' => false,
                ]);
                $qrCodeSvg = (new \chillerlan\QRCode\QRCode($qrOptions))->render($qrData);
            ?>
            <div style="margin-right: 40px; text-align: center;">
                <div style="width: 100px; height: 100px; display: inline-block;">
                    <img src="<?= $qrCodeSvg ?>" alt="Invoice QR Code" style="width: 100%; height: 100%;" />
                </div>
                <div style="font-size: 0.65rem; color: #94a3b8; margin-top: 5px;">SCAN TO VERIFY</div>
            </div>
            <?php } catch (\Throwable $e) { echo "<div style='color:red;'>QR Error: " . $e->getMessage() . "</div>"; } ?>

            <div style="width: 300px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; color: #64748b;">
                    <span>Subtotal</span>
                    <span><?= $this->formatCurrency($subtotal, $currencyCode) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; color: #64748b;">
                    <span>Tax (VAT)</span>
                    <span><?= $this->formatCurrency($totalVat, $currencyCode) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #0f172a; margin-top: 10px; font-weight: 800; font-size: 1.25rem; color: #0f172a;">
                    <span>Total</span>
                    <span><?= $this->formatCurrency($invoice->total, $currencyCode) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; color: #16a34a; font-weight: 600;">
                    <span>Amount Paid</span>
                    <span><?= $this->formatCurrency($totalPaid, $currencyCode) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-top: 1px solid #e2e8f0; font-weight: 800; font-size: 1.1rem; color: <?= $balanceDue > 0.01 ? '#dc2626' : '#16a34a' ?>;">
                    <span>Balance Due</span>
                    <span><?= $this->formatCurrency($balanceDue, $currencyCode) ?></span>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($invoice->receipts)) : ?>
    <div class="related no-print" style="margin-top: 40px; border-top: 1px dashed #e2e8f0; padding-top: 30px;">
        <h4 style="color: #64748b; font-size: 0.9rem; text-transform: uppercase; margin-bottom: 15px;">Payments Received</h4>
        <div class="table-responsive">
            <table class="table" style="font-size: 0.85rem;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="border-bottom: 1px solid #e2e8f0;">Receipt ID</th>
                        <th style="border-bottom: 1px solid #e2e8f0;">Date</th>
                        <th style="border-bottom: 1px solid #e2e8f0;">Reference / Method</th>
                        <th style="border-bottom: 1px solid #e2e8f0;">Status</th>
                        <th class="text-right" style="border-bottom: 1px solid #e2e8f0;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($invoice->receipts as $receipt) : ?>
                <tr>
                    <td><?= $this->Html->link("RCT-{$receipt->id}", ['controller' => 'Receipts', 'action' => 'view', $receipt->id]) ?></td>
                    <td><?= h($receipt->date) ?></td>
                    <td><?= h($receipt->reference ?: '—') ?></td>
                    <td>
                        <span style="background: <?= $receipt->status === 'Approved' ? '#f0fdf4' : '#f1f5f9' ?>; padding: 2px 8px; border-radius: 12px; color: <?= $receipt->status === 'Approved' ? '#16a34a' : '#0f172a' ?>; font-size: 0.75rem; font-weight: 600;">
                            <?= h($receipt->status) ?>
                        </span>
                    </td>
                    <td class="text-right" style="font-weight: 600;"><?= $this->formatCurrency($receipt->amount, $currencyCode) ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($invoice->transactions)) : ?>
    <div class="related no-print" style="margin-top: 60px; border-top: 1px dashed #e2e8f0; padding-top: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h4 style="color: #64748b; font-size: 0.9rem; text-transform: uppercase; margin: 0;">Accounting & Reconciliation Trail</h4>
            <span style="font-size: 0.8rem; color: #94a3b8;"><i class="fa fa-info-circle"></i> This section shows all ledger entries linked to this invoice, including payments.</span>
        </div>
        <div class="table-responsive">
            <table class="table" style="font-size: 0.85rem;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="border-bottom: 1px solid #e2e8f0;">Date</th>
                        <th style="border-bottom: 1px solid #e2e8f0;">Description / Reference</th>
                        <th style="border-bottom: 1px solid #e2e8f0;">Account</th>
                        <th style="border-bottom: 1px solid #e2e8f0;">Type</th>
                        <th class="text-right" style="border-bottom: 1px solid #e2e8f0;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($invoice->transactions as $transaction) : 
                    $isOffset = strpos(strtolower($transaction->description), 'payment') !== false || strpos(strtolower($transaction->description), 'receipt') !== false;
                ?>
                <tr style="<?= $isOffset ? 'background: #f0fdf4;' : '' ?>">
                    <td><?= h($transaction->date) ?></td>
                    <td>
                        <?= h($transaction->description) ?>
                        <?php if ($transaction->manual_reference): ?>
                            <br><small class="text-muted">Ref: <?= h($transaction->manual_reference) ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?= $transaction->hasValue('account') ? h($transaction->account->name) : '—' ?></td>
                    <td><span style="color: <?= $transaction->type === 'Debit' ? '#16a34a' : '#dc2626' ?>; font-weight: 600;"><?= h($transaction->type) ?></span></td>
                    <td class="text-right" style="font-weight: 600;"><?= $this->formatCurrency($transaction->amount, $transaction->currency) ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .text-right { text-align: right !important; }
    .text-center { text-align: center !important; }
</style>
