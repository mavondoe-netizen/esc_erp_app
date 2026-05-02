<?php
/**
 * @var \App\Model\Entity\Estimate $estimate
 * @var \App\Model\Entity\Company $company
 */

$this->assign('actions', $this->element('document_actions', [
    'entity' => $estimate,
    'controller' => 'Estimates',
    'approval_workflow' => false
]));
?>
<div class="estimates view content">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; border-bottom: 2px solid #f1f5f9; padding-bottom: 30px;">
        <div>
            <?php if (!empty($company->logo)): ?>
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
            <h1 style="font-size: 2.5rem; letter-spacing: -0.02em; color: #4b5563; margin-bottom: 10px;">ESTIMATE</h1>
            <div style="color: #64748b;">
                <strong>Estimate #:</strong> <span style="color: #0f172a;"><?= h($estimate->id) ?></span><br>
                <strong>Date:</strong> <span style="color: #0f172a;"><?= h($estimate->date) ?></span><br>
                <strong>Expiry:</strong> <span style="color: #0f172a;"><?= h($estimate->expiry_date) ?></span><br>
                <strong>Status:</strong> <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 20px; color: #0f172a; font-weight: 600; font-size: 0.8rem;"><?= strtoupper(h($estimate->status)) ?></span>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
        <div>
            <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Estimate For</h4>
            <h3 style="margin-bottom: 5px;"><?= $estimate->hasValue('customer') ? h($estimate->customer->name) : '—' ?></h3>
            <?php if ($estimate->description): ?>
                <p style="color: #64748b; line-height: 1.5;">
                    <?= h($estimate->description) ?>
                </p>
            <?php endif; ?>
        </div>
        <div style="text-align: right;">
             <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Estimate Total</h4>
             <h2 style="color: #4b5563; font-size: 2.2rem; margin: 0;"><?= $this->Number->currency($estimate->total) ?></h2>
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
                foreach ($estimate->estimate_items as $item) : 
                    $subtotal += ($item->quantity * $item->unit_price);
                    $totalVat += ($item->vat_amount ?? 0);
                ?>
                <tr>
                    <td>
                        <strong style="color: #0f172a;"><?= $item->hasValue('product') ? h($item->product->name) : 'Custom Item' ?></strong><br>
                        <small style="color: #64748b;"><?= h($item->description) ?></small>
                    </td>
                    <td class="text-center"><?= $this->Number->format($item->quantity) ?></td>
                    <td class="text-right"><?= $this->Number->currency($item->unit_price) ?></td>
                    <td class="text-right">
                        <span style="display: block; font-size: 0.75rem; color: #94a3b8;"><?= $this->Number->format($item->vat_rate) ?>%</span>
                        <?= $this->Number->currency($item->vat_amount) ?>
                    </td>
                    <td class="text-right" style="font-weight: 600; color: #0f172a;"><?= $this->Number->currency($item->line_total) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
            <div style="width: 300px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; color: #64748b;">
                    <span>Subtotal</span>
                    <span><?= $this->Number->currency($subtotal) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; color: #64748b;">
                    <span>Tax (VAT)</span>
                    <span><?= $this->Number->currency($totalVat) ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #0f172a; margin-top: 10px; font-weight: 800; font-size: 1.25rem; color: #0f172a;">
                    <span>Total</span>
                    <span><?= $this->Number->currency($estimate->total) ?></span>
                </div>
            </div>
        </div>
    </div>


</div>

<style>
    .text-right { text-align: right !important; }
    .text-center { text-align: center !important; }
</style>