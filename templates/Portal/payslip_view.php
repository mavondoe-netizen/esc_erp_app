<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payslip $payslip
 * @var \App\Model\Entity\Company $company
 * @var iterable $leaveBalances
 */
$this->assign('title', 'Payslip View');

// Separate items
$earnings = []; $deductions = []; $taxes = [];
foreach ($payslip->payslip_items as $item) {
    if ($item->item_type === 'Earning') $earnings[] = $item;
    elseif ($item->item_type === 'Deduction') $deductions[] = $item;
    elseif ($item->item_type === 'Tax') $taxes[] = $item;
}
?>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
    <h2><i class="fa fa-file-invoice-dollar" style="color:#2563eb;margin-right:0.5rem;"></i> Payslip</h2>
    <div style="display:flex; gap:0.75rem;">
        <a href="/portal/payslips" class="btn-outline" style="text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem;">
            <i class="fa fa-arrow-left"></i> Back
        </a>
        <button onclick="window.print()" class="btn-portal" style="display:inline-flex; align-items:center; gap:0.4rem;">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
</div>

<div class="portal-card" id="payslip-print-area">
    <!-- Company Header -->
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem; border-bottom:2px solid #e2e8f0; padding-bottom:1.5rem;">
        <div>
            <?php if ($company->logo): ?>
                <img src="<?= h($company->logo) ?>" style="max-height:70px; border-radius:6px;" alt="Logo">
            <?php else: ?>
                <div style="font-size:1.4rem; font-weight:800; color:#1e293b;"><?= h($company->name) ?></div>
            <?php endif; ?>
            <div style="font-size:0.83rem; color:#64748b; margin-top:0.4rem;">
                <?= h($company->address ?? '') ?><br>
                <?= h($company->email ?? '') ?> | <?= h($company->phone ?? '') ?>
            </div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:1.6rem; font-weight:800; color:#2563eb; letter-spacing:1px;">PAYSLIP</div>
            <div style="font-size:0.85rem; color:#64748b; margin-top:0.35rem;">
                Period: <strong><?= $payslip->hasValue('pay_period') ? h($payslip->pay_period->name) : '—' ?></strong>
            </div>
            <div style="font-size:0.85rem; color:#64748b;">
                Generated: <strong><?= h($payslip->generated_date) ?></strong>
            </div>
        </div>
    </div>

    <!-- Employee Info -->
    <div style="background:#f8fafc; border-radius:10px; padding:1rem 1.25rem; margin-bottom:1.5rem; display:flex; gap:2rem; flex-wrap:wrap;">
        <div><span style="font-size:0.75rem;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Employee</span><br>
            <strong><?= h($payslip->employee->first_name . ' ' . $payslip->employee->last_name) ?></strong></div>
        <div><span style="font-size:0.75rem;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Employee Code</span><br>
            <strong><?= h($payslip->employee->employee_code) ?></strong></div>
        <div><span style="font-size:0.75rem;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Department</span><br>
            <strong><?= h($payslip->employee->department ?? '—') ?></strong></div>
    </div>

    <!-- Earnings -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-bottom:1.5rem;">
        <div>
            <h4 style="font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; margin-bottom:0.75rem; border-bottom:1px solid #e2e8f0; padding-bottom:0.4rem;">Earnings</h4>
            <table style="width:100%;">
                <?php foreach ($earnings as $e): ?>
                <tr>
                    <td style="padding:4px 0; font-size:0.88rem;"><?= h($e->name) ?></td>
                    <td style="padding:4px 0; font-size:0.88rem; text-align:right;"><?= h($e->currency ?? 'USD') ?> <?= number_format($e->amount, 2) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr style="border-top:2px solid #e2e8f0;">
                    <td style="padding:6px 0; font-weight:700;">Gross Pay</td>
                    <td style="padding:6px 0; font-weight:700; text-align:right; color:#16a34a;"><?= number_format($payslip->gross_pay, 2) ?></td>
                </tr>
            </table>
        </div>
        <div>
            <h4 style="font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; margin-bottom:0.75rem; border-bottom:1px solid #e2e8f0; padding-bottom:0.4rem;">Deductions & Taxes</h4>
            <table style="width:100%;">
                <?php foreach (array_merge($deductions, $taxes) as $d): ?>
                <tr>
                    <td style="padding:4px 0; font-size:0.88rem;"><?= h($d->name) ?></td>
                    <td style="padding:4px 0; font-size:0.88rem; text-align:right; color:#dc2626;">(<?= number_format($d->amount, 2) ?>)</td>
                </tr>
                <?php endforeach; ?>
                <tr style="border-top:2px solid #e2e8f0;">
                    <td style="padding:6px 0; font-weight:700;">Total Deductions</td>
                    <td style="padding:6px 0; font-weight:700; text-align:right; color:#dc2626;">(<?= number_format($payslip->total_deductions, 2) ?>)</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Net Pay Banner -->
    <div style="background:linear-gradient(135deg,#2563eb,#0ea5e9); color:white; border-radius:10px; padding:1.25rem 1.5rem; display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <div style="font-size:1rem; font-weight:600; opacity:0.9;">Net Pay</div>
        <div style="font-size:1.8rem; font-weight:800;"><?= number_format($payslip->net_pay, 2) ?></div>
    </div>

    <!-- Leave Balances -->
    <?php if (count($leaveBalances) > 0): ?>
    <div style="margin-top:1rem;">
        <h4 style="font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; margin-bottom:0.75rem; border-bottom:1px solid #e2e8f0; padding-bottom:0.4rem;">Leave Balance Summary</h4>
        <table style="width:100%;">
            <tr>
                <?php foreach ($leaveBalances as $lb): ?>
                <td style="padding:6px 12px; text-align:center; background:#f8fafc; border-radius:8px; margin-right:8px;">
                    <div style="font-size:0.75rem; color:#64748b;"><?= h($lb->leave_type->name) ?></div>
                    <div style="font-weight:700; font-size:1.1rem;"><?= ($lb->days_entitled - $lb->days_taken) ?> <span style="font-size:0.75rem; font-weight:400;">days left</span></div>
                </td>
                <?php endforeach; ?>
            </tr>
        </table>
    </div>
    <?php endif; ?>

    <div style="margin-top:1.5rem; font-size:0.75rem; color:#94a3b8; text-align:center; border-top:1px solid #e2e8f0; padding-top:1rem;">
        This payslip is generated electronically and is valid without a signature.
    </div>
</div>

<style>
@media print {
    .portal-topbar, .portal-sidebar, h2 > a, .btn-portal, .btn-outline, .no-print { display: none !important; }
    .portal-main { padding: 0 !important; }
    .portal-card { box-shadow: none !important; }
}
</style>
