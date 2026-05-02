<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bill $bill
 * @var \App\Model\Entity\Company $company
 */

$this->assign('actions', $this->element('document_actions', [
    'entity' => $bill,
    'controller' => 'Bills',
    'approval_workflow' => false // Bills might not use workflow yet
]));
?>
<div class="bills view content">
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
            <h1 style="font-size: 2.5rem; letter-spacing: -0.02em; color: #dc2626; margin-bottom: 10px;">BILL</h1>
            <div style="color: #64748b;">
                <strong>Bill #:</strong> <span style="color: #0f172a;"><?= h($bill->id) ?></span><br>
                <?php if ($bill->manual_reference): ?>
                    <strong>Reference:</strong> <span style="color: #0f172a;"><?= h($bill->manual_reference) ?></span><br>
                <?php endif; ?>
                <strong>Date:</strong> <span style="color: #0f172a;"><?= h($bill->date) ?></span><br>
                <strong>Currency:</strong> <span style="color: #0f172a;"><?= h($bill->currency) ?></span>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
        <div>
            <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Payable To</h4>
            <h3 style="margin-bottom: 5px;"><?= $bill->hasValue('supplier') ? h($bill->supplier->name) : '—' ?></h3>
            <p style="color: #64748b; line-height: 1.5;">
                <?= h($bill->description) ?>
            </p>
        </div>
        <div style="text-align: right;">
             <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Total Amount Due</h4>
             <h2 style="color: #dc2626; font-size: 2.2rem; margin: 0;"><?= $this->Number->currency($bill->total, $bill->currency) ?></h2>
        </div>
    </div>

    <div class="related">
        <h4 style="color: #64748b; font-size: 0.9rem; text-transform: uppercase; margin-bottom: 20px;">Bill Items</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Account</th>
                    <th class="text-center" style="width: 60px;">Qty</th>
                    <th class="text-right" style="width: 110px;">Unit Price</th>
                    <th class="text-right" style="width: 100px;">VAT</th>
                    <th class="text-right" style="width: 120px;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bill->bill_items)): ?>
                    <?php foreach ($bill->bill_items as $item): ?>
                    <tr>
                        <td><?= h($item->description ?: 'Line Item') ?></td>
                        <td><?= $item->hasValue('account') ? h($item->account->name) : '—' ?></td>
                        <td class="text-center"><?= $this->Number->format($item->quantity) ?></td>
                        <td class="text-right"><?= $this->Number->currency($item->unit_price, $bill->currency) ?></td>
                        <td class="text-right">
                             <span style="display: block; font-size: 0.75rem; color: #94a3b8;"><?= $this->Number->format($item->vat_rate) ?>%</span>
                             <?= $this->Number->currency($item->vat_amount, $bill->currency) ?>
                        </td>
                        <td class="text-right" style="font-weight: 600;"><?= $this->Number->currency($item->line_total, $bill->currency) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($bill->transactions)) : ?>
    <div class="related no-print" style="margin-top: 60px; border-top: 1px dashed #e2e8f0; padding-top: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h4 style="color: #64748b; font-size: 0.9rem; text-transform: uppercase; margin: 0;">Accounting & Reconciliation Trail</h4>
            <span style="font-size: 0.8rem; color: #94a3b8;"><i class="fa fa-info-circle"></i> This section shows all ledger entries linked to this bill, including payments.</span>
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
                <?php foreach ($bill->transactions as $transaction) : 
                    $isOffset = strpos(strtolower($transaction->description), 'payment') !== false || strpos(strtolower($transaction->description), 'bill payment') !== false;
                ?>
                <tr style="<?= $isOffset ? 'background: #fef2f2;' : '' ?>">
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