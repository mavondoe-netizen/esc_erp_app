<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $applications
 */
$this->assign('title', 'Leave History');
?>
<h2><i class="fa fa-clock-rotate-left" style="color:#2563eb;margin-right:0.5rem;"></i> Leave History</h2>

<div class="portal-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <h3 style="margin:0;">All Applications</h3>
        <a href="/portal/leave-apply" class="btn-portal" style="text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem; padding:0.5rem 1rem; font-size:0.85rem;">
            <i class="fa fa-plus"></i> New Application
        </a>
    </div>

    <?php if (count($applications) > 0): ?>
    <table class="portal-table">
        <thead>
            <tr>
                <th>Leave Type</th>
                <th>From</th>
                <th>To</th>
                <th>Days</th>
                <th>Reason</th>
                <th>Applied On</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $app): ?>
            <tr>
                <td><strong><?= $app->hasValue('leave_type') ? h($app->leave_type->name) : '—' ?></strong></td>
                <td><?= h($app->start_date) ?></td>
                <td><?= h($app->end_date) ?></td>
                <td><?= $app->days_requested ?></td>
                <td style="color:#64748b;"><?= h($app->reason ?? '—') ?></td>
                <td style="color:#64748b;"><?= $app->created->format('d M Y') ?></td>
                <td>
                    <?php
                    $status = strtolower($app->status ?? 'pending');
                    $badgeClass = match($status) {
                        'approved' => 'badge-approved',
                        'rejected' => 'badge-rejected',
                        default => 'badge-pending'
                    };
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div style="text-align:center; padding:2.5rem; color:#94a3b8;">
        <i class="fa fa-calendar-xmark" style="font-size:2rem; margin-bottom:0.75rem; display:block;"></i>
        No leave applications yet.
        <br><br>
        <a href="/portal/leave-apply" class="btn-portal" style="text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem; font-size:0.85rem;">
            <i class="fa fa-plus"></i> Apply for Leave
        </a>
    </div>
    <?php endif; ?>
</div>
