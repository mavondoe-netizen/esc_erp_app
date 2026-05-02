<?php
/**
 * @var \App\Model\Entity\Payment $payment
 * @var \App\Model\Entity\Company $company
 */

$this->assign('actions', $this->element('document_actions', [
    'entity' => $payment,
    'controller' => 'Payments',
    'approval_workflow' => false
]));
?>
<div class="payments view content">
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
            <h1 style="font-size: 2.5rem; letter-spacing: -0.02em; color: #dc2626; margin-bottom: 10px;">PAYMENT ADVICE</h1>
            <div style="color: #64748b;">
                <strong>Payment #:</strong> <span style="color: #0f172a;"><?= h($payment->id) ?></span><br>
                <strong>Date:</strong> <span style="color: #0f172a;"><?= h($payment->date) ?></span><br>
                <?php if ($payment->reference): ?>
                    <strong>Reference:</strong> <span style="color: #0f172a;"><?= h($payment->reference) ?></span><br>
                <?php endif; ?>
                <strong>Status:</strong> <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 20px; color: #0f172a; font-weight: 600; font-size: 0.8rem;"><?= strtoupper(h($payment->status ?? 'APPROVED')) ?></span>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
        <div>
            <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Paid To</h4>
            <h3 style="margin-bottom: 5px;"><?= $payment->hasValue('supplier') ? h($payment->supplier->name) : '—' ?></h3>
            <?php if ($payment->description): ?>
                <p style="color: #64748b; line-height: 1.5;">
                    <?= h($payment->description) ?>
                </p>
            <?php endif; ?>
        </div>
        <div style="text-align: right;">
             <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 10px;">Total Amount Paid</h4>
             <h2 style="color: #dc2626; font-size: 2.2rem; margin: 0;"><?= $this->Number->currency($payment->amount, $payment->currency) ?></h2>
             <p style="color: #64748b; margin-top: 5px;">Paid from: <strong><?= $payment->hasValue('account') ? h($payment->account->name) : '—' ?></strong></p>
        </div>
    </div>

    <?php if (!empty($payment->transactions)): ?>
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
                <?php foreach ($payment->transactions as $transaction): ?>
                <tr>
                    <td><?= h($transaction->date) ?></td>
                    <td><?= $transaction->hasValue('account') ? h($transaction->account->name) : h($transaction->account_id) ?></td>
                    <td><span style="color: <?= $transaction->type === 'Debit' ? '#16a34a' : '#dc2626' ?>; font-weight: 600;"><?= h($transaction->type) ?></span></td>
                    <td class="text-right"><?= $this->Number->currency($transaction->amount, $transaction->currency) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <?php else: ?>
        <div class="no-print" style="margin-top: 40px; background: #fffbeb; border: 1px solid #fde68a; padding: 20px; border-radius: 8px;">
             <p style="color: #92400e; margin: 0; font-style: italic;"><i class="fa fa-info-circle"></i> No transactions posted yet.</p>
        </div>
    <?php endif; ?>
</div>

<style>
    .text-right { text-align: right !important; }
</style>

<style>
    .text-right { text-align: right !important; }
</style>