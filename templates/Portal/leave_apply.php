<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveApplication $leaveApplication
 * @var array $leaveTypes
 * @var iterable $leaveBalances
 */
$this->assign('title', 'Apply for Leave');
?>
<h2><i class="fa fa-calendar-plus" style="color:#2563eb;margin-right:0.5rem;"></i> Apply for Leave</h2>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; align-items:start;">
    <!-- Application Form -->
    <div class="portal-card">
        <h3>Leave Application Form</h3>
        <?= $this->Form->create($leaveApplication, ['class' => 'portal-form']) ?>
        
        <div class="form-group">
            <label>Leave Type <span style="color:#dc2626;">*</span></label>
            <?= $this->Form->select('leave_type_id', $leaveTypes, [
                'empty' => '— Select Leave Type —',
                'required' => true,
                'id' => 'leave-type-sel'
            ]) ?>
        </div>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
            <div class="form-group">
                <label>Start Date <span style="color:#dc2626;">*</span></label>
                <?= $this->Form->date('start_date', ['required' => true, 'id' => 'start-date', 'min' => date('Y-m-d')]) ?>
            </div>
            <div class="form-group">
                <label>End Date <span style="color:#dc2626;">*</span></label>
                <?= $this->Form->date('end_date', ['required' => true, 'id' => 'end-date', 'min' => date('Y-m-d')]) ?>
            </div>
        </div>

        <div class="form-group" style="background:#f8fafc; border-radius:8px; padding:0.75rem 1rem;">
            <label style="color:#64748b;">Days Requested</label>
            <div id="days-display" style="font-size:1.5rem; font-weight:700; color:#2563eb;">— days</div>
        </div>
        
        <div class="form-group">
            <label>Reason / Notes</label>
            <?= $this->Form->textarea('reason', ['rows' => 3, 'placeholder' => 'Brief reason for your leave request...']) ?>
        </div>
        
        <div style="display:flex; gap:0.75rem; margin-top:0.5rem;">
            <?= $this->Form->button('Submit Application', ['class' => 'btn-portal']) ?>
            <a href="/portal/dashboard" class="btn-outline" style="text-decoration:none; display:inline-flex; align-items:center;">Cancel</a>
        </div>
        <?= $this->Form->end() ?>
    </div>

    <!-- Balances Sidebar -->
    <div class="portal-card">
        <h3><i class="fa fa-calendar-check" style="margin-right:0.5rem;"></i> Your Balances</h3>
        <?php if (count($leaveBalances) > 0): ?>
            <?php foreach ($leaveBalances as $lb): ?>
            <?php $remaining = $lb->days_entitled - $lb->days_taken; ?>
            <div style="margin-bottom:1rem; padding-bottom:1rem; border-bottom:1px solid #f1f5f9;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <strong style="font-size:0.88rem;"><?= h($lb->leave_type->name) ?></strong>
                    <span style="font-weight:700; color:<?= $remaining > 5 ? '#16a34a' : ($remaining > 0 ? '#ca8a04' : '#dc2626') ?>;">
                        <?= $remaining ?> left
                    </span>
                </div>
                <div style="background:#e2e8f0; border-radius:10px; height:6px; overflow:hidden;">
                    <div style="background:#2563eb; height:100%; width:<?= $lb->days_entitled > 0 ? min(100, ($remaining/$lb->days_entitled)*100) : 0 ?>%;"></div>
                </div>
                <div style="font-size:0.75rem; color:#94a3b8; margin-top:3px;"><?= $lb->days_taken ?> of <?= $lb->days_entitled ?> days used</div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:#94a3b8; font-size:0.88rem;">No leave balances set up. Contact HR.</p>
        <?php endif; ?>
    </div>
</div>

<script>
function calcDays() {
    const s = document.getElementById('start-date').value;
    const e = document.getElementById('end-date').value;
    if (s && e) {
        const diff = Math.round((new Date(e) - new Date(s)) / 86400000) + 1;
        document.getElementById('days-display').textContent = (diff > 0 ? diff : 0) + ' days';
    }
}
document.getElementById('start-date').addEventListener('change', calcDays);
document.getElementById('end-date').addEventListener('change', calcDays);
</script>
