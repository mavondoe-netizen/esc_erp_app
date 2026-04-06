<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
$this->assign('title', 'My Profile');
$profile = $employee->employee_profile ?? $employee->employee_profiles[0] ?? null;
?>
<h2><i class="fa fa-user" style="color:#2563eb;margin-right:0.5rem;"></i> My Profile</h2>

<div class="portal-card">
    <div style="display:flex; align-items:center; gap:1.5rem; margin-bottom:1.5rem; padding-bottom:1.5rem; border-bottom:1px solid #e2e8f0;">
        <div style="width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,#2563eb,#0ea5e9); display:flex; align-items:center; justify-content:center; color:white; font-size:1.8rem; font-weight:700; flex-shrink:0;">
            <?= strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) ?>
        </div>
        <div>
            <h3 style="margin:0; font-size:1.3rem;"><?= h($employee->first_name . ' ' . $employee->last_name) ?></h3>
            <p style="margin:4px 0 0; color:#64748b; font-size:0.9rem;"><?= h($employee->employee_code) ?></p>
            <span style="background:#dbeafe; color:#1e40af; padding:2px 12px; border-radius:20px; font-size:0.78rem; font-weight:600;">Active Employee</span>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
        <!-- Personal Info -->
        <div>
            <h4 style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; margin-bottom:0.75rem;">Personal Information</h4>
            <table style="width:100%;">
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem; width:140px;">Full Name</td>
                    <td style="padding:6px 0; font-weight:600;"><?= h($employee->first_name . ' ' . $employee->last_name) ?></td></tr>
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem;">Employee Code</td>
                    <td style="padding:6px 0; font-weight:600;"><?= h($employee->employee_code) ?></td></tr>
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem;">Email</td>
                    <td style="padding:6px 0;"><?= h($employee->email ?? '—') ?></td></tr>
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem;">Mobile</td>
                    <td style="padding:6px 0;"><?= h($employee->mobile ?? '—') ?></td></tr>
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem;">Date of Birth</td>
                    <td style="padding:6px 0;"><?= h($employee->date_of_birth ?? '—') ?></td></tr>
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem;">National ID</td>
                    <td style="padding:6px 0;"><?= h($employee->national_identity ?? '—') ?></td></tr>
            </table>
        </div>

        <!-- Employment Info -->
        <div>
            <h4 style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; margin-bottom:0.75rem;">Employment Details</h4>
            <table style="width:100%;">
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem; width:140px;">Department</td>
                    <td style="padding:6px 0; font-weight:600;"><?= h($employee->department ?? '—') ?></td></tr>
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem;">Position</td>
                    <td style="padding:6px 0;"><?= h($employee->position ?? '—') ?></td></tr>
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem;">Join Date</td>
                    <td style="padding:6px 0;"><?= h($employee->join_date ?? $employee->created ?? '—') ?></td></tr>
                <tr><td style="padding:6px 0; color:#64748b; font-size:0.85rem;">Contract Type</td>
                    <td style="padding:6px 0;"><?= h($employee->contract_type ?? '—') ?></td></tr>
            </table>
        </div>
    </div>

    <?php if ($profile): ?>
    <div style="margin-top:1.5rem; padding-top:1.5rem; border-top:1px solid #e2e8f0;">
        <h4 style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; margin-bottom:0.75rem;">Banking & Payment</h4>
        <div style="background:#f8fafc; border-radius:8px; padding:0.75rem 1rem; display:flex; gap:2rem; flex-wrap:wrap;">
            <div><span style="font-size:0.75rem; color:#64748b;">Bank Name</span><br><strong><?= h($profile->bank_name ?? '—') ?></strong></div>
            <div><span style="font-size:0.75rem; color:#64748b;">Account Number</span><br><strong><?= h($profile->bank_account ?? $profile->account_number ?? '—') ?></strong></div>
        </div>
    </div>
    <?php endif; ?>

    <div style="margin-top:1.25rem; background:#fef9c3; border:1px solid #fde68a; border-radius:8px; padding:0.75rem 1rem; font-size:0.85rem; color:#92400e;">
        <i class="fa fa-info-circle"></i> To request changes to your profile, please contact your HR department.
    </div>
</div>
