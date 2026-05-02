<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 * @var \App\Model\Entity\Company $company
 */

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
            </p>
        </div>
        <div style="text-align: right;">
             <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Currency</h4>
             <h3 style="color: var(--primary-color);"><?= h($invoice->currency) ?></h3>
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
                    <td class="text-right"><?= $this->Number->currency($item->unit_price, $invoice->currency) ?></td>
                    <td class="text-right">
                        <span style="display: block; font-size: 0.75rem; color: #94a3b8;"><?= $this->Number->format($item->vat_rate) ?>%</span>
                        <?= $this->Number->currency($item->vat_amount, $invoice->currency) ?>
                    </td>
                    <td class="text-right" style="font-weight: 600; color: #0f172a;"><?= $this->Number->currency($item->line_total, $invoice->currency) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
            <div style="width: 300px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; color: #64748b;">
                    <span>Subtotal</span>
                    <span><?= $this->Number->currency($subtotal, $invoice->currency) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; color: #64748b;">
                    <span>Tax (VAT)</span>
                    <span><?= $this->Number->currency($totalVat, $invoice->currency) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #0f172a; margin-top: 10px; font-weight: 800; font-size: 1.25rem; color: #0f172a;">
                    <span>Total</span>
                    <span><?= $this->Number->currency($invoice->total, $invoice->currency) ?></span>
                </div>
            </div>
        </div>
    </div>

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
                    <td class="text-right" style="font-weight: 600;"><?= $this->Number->currency($transaction->amount, $transaction->currency) ?></td>
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