<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $payslips
 */
$this->assign('title', 'My Payslips');
?>
<h2><i class="fa fa-file-invoice-dollar" style="color:#2563eb;margin-right:0.5rem;"></i> My Payslips</h2>

<div class="portal-card">
    <h3>All Payslips</h3>
    <?php if (!empty($payslips) && count($payslips) > 0): ?>
    <table class="portal-table">
        <thead>
            <tr>
                <th>Pay Period</th>
                <th>Generated Date</th>
                <th>Gross Pay</th>
                <th>Total Deductions</th>
                <th>Net Pay</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payslips as $payslip): ?>
            <tr>
                <td><strong><?= $payslip->hasValue('pay_period') ? h($payslip->pay_period->name) : '—' ?></strong></td>
                <td><?= h($payslip->generated_date) ?></td>
                <td style="font-weight:600;"><?= number_format($payslip->gross_pay, 2) ?></td>
                <td style="color:#dc2626;"><?= number_format($payslip->total_deductions, 2) ?></td>
                <td style="color:#16a34a; font-weight:700; font-size:1.05rem;"><?= number_format($payslip->net_pay, 2) ?></td>
                <td>
                    <a href="/portal/payslip-view/<?= $payslip->id ?>" style="color:#2563eb; text-decoration:none; font-weight:600; font-size:0.85rem;">
                        <i class="fa fa-eye"></i> View
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div style="text-align:center; padding:2rem; color:#94a3b8;">
        <i class="fa fa-file-slash" style="font-size:2rem; margin-bottom:0.75rem; display:block;"></i>
        No payslips found. Contact HR if you believe this is incorrect.
    </div>
    <?php endif; ?>
</div>
