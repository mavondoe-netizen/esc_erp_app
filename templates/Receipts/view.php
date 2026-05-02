<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receipt $receipt
 * @var \App\Model\Entity\Company $company
 */

$this->assign('actions', $this->element('document_actions', [
    'entity' => $receipt,
    'controller' => 'Receipts',
    'approval_workflow' => true
]));
?>
<div class="receipts view content">
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
            <h1 style="font-size: 2.5rem; letter-spacing: -0.02em; color: #2d6a4f; margin-bottom: 10px;">RECEIPT</h1>
            <div style="color: #64748b;">
                <strong>Receipt #:</strong> <span style="color: #0f172a;"><?= h($receipt->id) ?></span><br>
                <strong>Date:</strong> <span style="color: #0f172a;"><?= h($receipt->date) ?></span><br>
                <?php if ($receipt->reference): ?>
                    <strong>Reference:</strong> <span style="color: #0f172a;"><?= h($receipt->reference) ?></span><br>
                <?php endif; ?>
                <strong>Status:</strong> <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 20px; color: #0f172a; font-weight: 600; font-size: 0.8rem;"><?= strtoupper(h($receipt->status)) ?></span>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
        <div>
            <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Received From</h4>
            <h3 style="margin-bottom: 5px;"><?= $receipt->hasValue('customer') ? h($receipt->customer->name) : '—' ?></h3>
            <?php if ($receipt->description): ?>
                <p style="color: #64748b; line-height: 1.5;">
                    <?= h($receipt->description) ?>
                </p>
            <?php endif; ?>
        </div>
        <div style="text-align: right;">
             <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Total Amount Paid</h4>
             <h2 style="color: #2d6a4f; font-size: 2.2rem; margin: 0;"><?= $this->Number->currency($receipt->amount, $receipt->currency) ?></h2>
             <p style="color: #64748b; margin-top: 5px;">Deposited into: <strong><?= $receipt->hasValue('account') ? h($receipt->account->name) : '—' ?></strong></p>
        </div>
    </div>

    <?php if (!empty($receipt->transactions)): ?>
    <div class="related no-print" style="margin-top: 60px; border-top: 1px dashed #e2e8f0; padding-top: 40px;">
        <h4 style="color: #64748b; font-size: 0.9rem; text-transform: uppercase; margin-bottom: 20px;">Posted Transactions (Internal Only)</h4>
        <div class="table-responsive">
            <table class="table" style="font-size: 0.85rem;">
                <tr>
                    <th>Date</th>
                    <th>Account</th>
                    <th>Type</th>
                    <th class="text-right">Amount</th>
                </tr>
                <?php foreach ($receipt->transactions as $transaction): ?>
                <tr>
                    <td><?= h($transaction->date) ?></td>
                    <td><?= h($transaction->account_id) ?></td>
                    <td><span style="color: <?= $transaction->type === 'Debit' ? '#16a34a' : '#dc2626' ?>; font-weight: 600;"><?= h($transaction->type) ?></span></td>
                    <td class="text-right"><?= $this->Number->currency($transaction->amount, $transaction->currency) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <?php else: ?>
        <div class="no-print" style="margin-top: 40px; background: #fffbeb; border: 1px solid #fde68a; padding: 20px; border-radius: 8px;">
            <?php if ($receipt->status === 'Approved'): ?>
                <p style="color: #92400e; margin: 0; font-style: italic;"><i class="fa fa-info-circle"></i> No transactions posted yet.</p>
            <?php elseif ($receipt->status !== 'Rejected'): ?>
                <p style="color: #92400e; margin: 0; font-style: italic;"><i class="fa fa-clock"></i> Transactions will be posted once this receipt is approved.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .text-right { text-align: right !important; }
</style>