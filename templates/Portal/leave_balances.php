<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $leaveBalances
 * @var int $year
 */
$this->assign('title', 'Leave Balances');
?>
<h2><i class="fa fa-calendar-check" style="color:#2563eb;margin-right:0.5rem;"></i> Leave Balances — <?= $year ?></h2>

<div class="portal-card">
    <h3>Current Year Entitlements</h3>
    <?php if (count($leaveBalances) > 0): ?>
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px,1fr)); gap:1rem; margin-top:0.5rem;">
        <?php foreach ($leaveBalances as $lb): ?>
        <?php
        $remaining = $lb->days_entitled - $lb->days_taken;
        $pct = $lb->days_entitled > 0 ? round(($remaining / $lb->days_entitled) * 100) : 0;
        $color = $pct > 60 ? '#16a34a' : ($pct > 30 ? '#ca8a04' : '#dc2626');
        ?>
        <div style="background:#f8fafc; border-radius:12px; padding:1.25rem; border:1px solid #e2e8f0;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
                <strong style="font-size:0.95rem;"><?= h($lb->leave_type->name) ?></strong>
                <span style="font-size:0.8rem; background:#e2e8f0; padding:2px 10px; border-radius:20px; color:#475569;"><?= $lb->leave_type->category ?? 'Leave' ?></span>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:0.5rem; text-align:center; margin-bottom:0.75rem;">
                <div>
                    <div style="font-size:1.4rem; font-weight:700;"><?= $lb->days_entitled ?></div>
                    <div style="font-size:0.72rem; color:#64748b; text-transform:uppercase;">Entitled</div>
                </div>
                <div>
                    <div style="font-size:1.4rem; font-weight:700; color:#dc2626;"><?= $lb->days_taken ?></div>
                    <div style="font-size:0.72rem; color:#64748b; text-transform:uppercase;">Taken</div>
                </div>
                <div>
                    <div style="font-size:1.4rem; font-weight:700; color:<?= $color ?>;"><?= $remaining ?></div>
                    <div style="font-size:0.72rem; color:#64748b; text-transform:uppercase;">Remaining</div>
                </div>
            </div>
            <div style="background:#e2e8f0; border-radius:10px; height:8px; overflow:hidden;">
                <div style="background:<?= $color ?>; height:100%; width:<?= $pct ?>%; transition:width 0.5s;"></div>
            </div>
            <div style="text-align:right; font-size:0.72rem; color:#94a3b8; margin-top:4px;"><?= $pct ?>% remaining</div>
        </div>
        <?php endforeach; ?>
    </div>
    <div style="margin-top:1.5rem;">
        <a href="/portal/leave-apply" class="btn-portal" style="text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem;">
            <i class="fa fa-calendar-plus"></i> Apply for Leave
        </a>
    </div>
    <?php else: ?>
    <div style="text-align:center; padding:2rem; color:#94a3b8;">
        <i class="fa fa-calendar-xmark" style="font-size:2rem; margin-bottom:0.75rem; display:block;"></i>
        No leave balances found for <?= $year ?>. Contact HR to set up your entitlements.
    </div>
    <?php endif; ?>
</div>
