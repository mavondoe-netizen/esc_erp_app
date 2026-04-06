<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 * @var \App\Model\Entity\Payslip|null $latestPayslip
 * @var iterable $leaveBalances
 * @var iterable $pendingLeave
 */
$this->assign('title', 'My Dashboard');
?>
<h2><i class="fa fa-gauge-high" style="color:#2563eb;margin-right:0.5rem;"></i> My Dashboard</h2>

<!-- Stat Cards -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="icon blue"><i class="fa fa-file-invoice-dollar"></i></div>
        <div>
            <div class="label">Latest Payslip</div>
            <div class="value" style="font-size:1rem;margin-top:2px;">
                <?= $latestPayslip ? h($latestPayslip->pay_period->name) : 'N/A' ?>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon green"><i class="fa fa-calendar-check"></i></div>
        <div>
            <div class="label">Leave Types</div>
            <div class="value"><?= count($leaveBalances) ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="icon amber"><i class="fa fa-hourglass-half"></i></div>
        <div>
            <div class="label">Pending Applications</div>
            <div class="value"><?= count($pendingLeave) ?></div>
        </div>
    </div>
    <?php
    $totalRemaining = 0;
    foreach ($leaveBalances as $lb) {
        $totalRemaining += ($lb->days_entitled - $lb->days_taken);
    }
    ?>
    <div class="stat-card">
        <div class="icon blue"><i class="fa fa-umbrella-beach"></i></div>
        <div>
            <div class="label">Leave Days Left</div>
            <div class="value"><?= $totalRemaining ?></div>
        </div>
    </div>
</div>

<!-- Latest Payslip Summary -->
<?php if ($latestPayslip): ?>
<div class="portal-card">
    <h3><i class="fa fa-file-invoice-dollar" style="margin-right:0.5rem;"></i> Latest Payslip — <?= h($latestPayslip->pay_period->name) ?></h3>
    <div style="display:flex; gap:2rem; flex-wrap:wrap;">
        <div><span style="color:#64748b;font-size:0.85rem;">Gross Pay</span><br><strong style="font-size:1.3rem;"><?= number_format($latestPayslip->gross_pay, 2) ?></strong></div>
        <div><span style="color:#64748b;font-size:0.85rem;">Net Pay</span><br><strong style="font-size:1.3rem; color:#16a34a;"><?= number_format($latestPayslip->net_pay, 2) ?></strong></div>
        <div><span style="color:#64748b;font-size:0.85rem;">Period</span><br><strong><?= h($latestPayslip->pay_period->name) ?></strong></div>
    </div>
    <div style="margin-top:1rem;">
        <a href="/portal/payslip-view/<?= $latestPayslip->id ?>" class="btn-portal" style="display:inline-block;text-decoration:none; padding:0.5rem 1.2rem; font-size:0.85rem;">
            <i class="fa fa-eye"></i> View Full Payslip
        </a>
    </div>
</div>
<?php else: ?>
<div class="portal-card">
    <h3>Latest Payslip</h3>
    <p style="color:#94a3b8;">No payslip records found yet. Contact HR if you believe this is an error.</p>
</div>
<?php endif; ?>

<!-- Leave Balances Summary -->
<div class="portal-card">
    <h3><i class="fa fa-calendar-check" style="margin-right:0.5rem;"></i> Leave Balances — <?= date('Y') ?></h3>
    <?php if (count($leaveBalances) > 0): ?>
    <table class="portal-table">
        <thead>
            <tr>
                <th>Leave Type</th>
                <th>Entitled</th>
                <th>Taken</th>
                <th>Remaining</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leaveBalances as $lb): ?>
            <?php $remaining = $lb->days_entitled - $lb->days_taken; ?>
            <tr>
                <td><strong><?= h($lb->leave_type->name) ?></strong></td>
                <td><?= $lb->days_entitled ?> days</td>
                <td><?= $lb->days_taken ?> days</td>
                <td>
                    <span style="color:<?= $remaining > 5 ? '#16a34a' : ($remaining > 0 ? '#ca8a04' : '#dc2626') ?>; font-weight:700;">
                        <?= $remaining ?> days
                    </span>
                </td>
                <td>
                    <div style="background:#e2e8f0; border-radius:10px; height:8px; width:100px; overflow:hidden;">
                        <div style="background:#2563eb; height:100%; width:<?= $lb->days_entitled > 0 ? min(100, ($remaining/$lb->days_entitled)*100) : 0 ?>%;"></div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="margin-top:1rem;">
        <a href="/portal/leave-apply" class="btn-portal" style="display:inline-block;text-decoration:none; padding:0.5rem 1.2rem; font-size:0.85rem;">
            <i class="fa fa-calendar-plus"></i> Apply for Leave
        </a>
    </div>
    <?php else: ?>
    <p style="color:#94a3b8;">No leave balances configured. Contact HR.</p>
    <?php endif; ?>
</div>

<!-- Pending Applications -->
<?php if (count($pendingLeave) > 0): ?>
<div class="portal-card">
    <h3><i class="fa fa-hourglass-half" style="margin-right:0.5rem; color:#ca8a04;"></i> Pending Leave Applications</h3>
    <table class="portal-table">
        <thead><tr><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Status</th></tr></thead>
        <tbody>
            <?php foreach ($pendingLeave as $app): ?>
            <tr>
                <td><?= h($app->reason ?? 'Leave') ?></td>
                <td><?= h($app->start_date) ?></td>
                <td><?= h($app->end_date) ?></td>
                <td><?= $app->days_requested ?></td>
                <td><span class="badge badge-pending">Pending</span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
