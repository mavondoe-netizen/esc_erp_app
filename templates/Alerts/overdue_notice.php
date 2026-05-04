<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $record
 * @var string $entityName
 * @var float $balance
 * @var string $currency
 * @var \App\Model\Entity\Company $company
 * @var string $type
 */
$this->assign('title', 'FINAL NOTICE: Overdue Payment - ' . h($entityName));
?>
<div class="overdue-notice-letter" style="font-family: 'Inter', 'Segoe UI', sans-serif; max-width: 800px; margin: 0 auto; color: #1e293b; line-height: 1.6;">
    
    <!-- Letterhead -->
    <div style="text-align: right; margin-bottom: 50px;">
        <?php if ($company->logo): ?>
            <img src="<?= $company->logo ?>" style="max-height: 80px; margin-bottom: 10px;">
        <?php endif; ?>
        <h3 style="margin: 0; color: #0f172a; font-weight: 800;"><?= h($company->name) ?></h3>
        <p style="margin: 0; color: #64748b; font-size: 0.85rem;"><?= h($company->address) ?></p>
        <p style="margin: 0; color: #64748b; font-size: 0.85rem;">Date: <?= date('d F Y') ?></p>
    </div>

    <!-- Recipient -->
    <div style="margin-bottom: 40px;">
        <h4 style="margin: 0; font-weight: 700;">To: <?= h($entityName) ?></h4>
        <p style="margin: 0; color: #64748b; font-size: 0.9rem;">Regarding: Overdue Account Balance</p>
    </div>

    <!-- Header / Subject -->
    <div style="background: #fee2e2; border-left: 5px solid #dc2626; padding: 20px; margin-bottom: 30px;">
        <h3 style="margin: 0; color: #991b1b; text-transform: uppercase; font-weight: 900; letter-spacing: 0.5px;">Final Notice: Overdue Payment</h3>
    </div>

    <!-- Body -->
    <div style="font-size: 1rem; margin-bottom: 40px;">
        <p>Dear <?= h($entityName) ?>,</p>
        
        <p>We are writing to formally notify you that your account remains past due. Our records indicate that an outstanding balance of <strong style="color: #dc2626;"><?= h($currency) ?> <?= number_format($balance, 2) ?></strong> remains unpaid as of today.</p>

        <p>Despite previous reminders, we have not received payment for the following:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 25px 0; border: 1px solid #e2e8f0;">
            <thead style="background: #f8fafc;">
                <tr>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 0.8rem; text-transform: uppercase;">Reference</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 0.8rem; text-transform: uppercase;">Date</th>
                    <th style="padding: 12px; text-align: right; border-bottom: 1px solid #e2e8f0; font-size: 0.8rem; text-transform: uppercase;">Outstanding Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">
                        <?= $type === 'invoice' ? 'Invoice #' . h($record->reference ?: $record->id) : 'School Fees — ' . h($record->sch_student->admission_no) ?>
                    </td>
                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">
                        <?= ($type === 'invoice' ? $record->date : ($record->due_date ?: $record->created))->format('d M Y') ?>
                    </td>
                    <td style="padding: 12px; text-align: right; font-weight: 700; border-bottom: 1px solid #e2e8f0;">
                        <?= h($currency) ?> <?= number_format($balance, 2) ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <p>Please be advised that this balance must be settled within <strong>seven (7) working days</strong> from the date of this letter. Failure to do so may result in further action, including the suspension of services or academic access.</p>

        <p>If you have already made this payment, please provide a proof of payment to our finance department at your earliest convenience.</p>
    </div>

    <!-- Signature -->
    <div style="margin-top: 60px;">
        <p style="margin: 0;">Yours faithfully,</p>
        <div style="margin: 20px 0; border-bottom: 1px solid #cbd5e1; width: 200px;"></div>
        <p style="margin: 0; font-weight: 700;">Finance Department</p>
        <p style="margin: 0; color: #64748b; font-size: 0.9rem;"><?= h($company->name) ?></p>
    </div>

    <!-- Footer Note -->
    <div style="margin-top: 80px; font-size: 0.75rem; color: #94a3b8; text-align: center; border-top: 1px solid #f1f5f9; padding-top: 20px;">
        Please ignore this notice if payment has been made in the last 24 hours. <br>
        For inquiries, contact: <?= h($company->phone ?: 'Main Office') ?>
    </div>
</div>

<style>
@media print {
    body { background: white !important; }
    .no-print { display: none !important; }
}
</style>
