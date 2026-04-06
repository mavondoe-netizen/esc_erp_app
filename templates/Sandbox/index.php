<?php
/**
 * @var \App\View\AppView $this
 * @var array $tableList
 * @var bool $sandboxConnected
 * @var bool $sandboxModeActive
 */
$this->assign('title', 'Sandbox Environment');
?>

<?php if ($sandboxModeActive): ?>
<div style="background:linear-gradient(135deg,#f59e0b,#d97706); color:white; padding:0.85rem 1.5rem; border-radius:10px; display:flex; align-items:center; gap:0.75rem; margin-bottom:1.5rem; box-shadow:0 2px 8px rgba(217,119,6,0.4);">
    <i class="fa fa-flask" style="font-size:1.2rem;"></i>
    <div><strong>SANDBOX MODE ACTIVE</strong> — You are viewing test data only. Production data is unaffected.</div>
    <?= $this->Form->create(null, ['url' => ['action' => 'toggleMode'], 'style' => 'margin-left:auto;']) ?>
    <?= $this->Form->button('Exit Sandbox Mode', ['style' => 'background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.4); color:white; padding:5px 14px; border-radius:6px; cursor:pointer; font-weight:600;']) ?>
    <?= $this->Form->end() ?>
</div>
<?php endif; ?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
    <div>
        <h2 style="margin:0;"><i class="fa fa-flask" style="color:#f59e0b;margin-right:0.5rem;"></i> Sandbox Environment</h2>
        <p style="color:#64748b; margin:4px 0 0; font-size:0.9rem;">Test new features safely without touching production data.</p>
    </div>
    <span style="padding:4px 16px; border-radius:20px; font-weight:700; font-size:0.85rem; background:<?= $sandboxConnected ? '#dcfce7' : '#fee2e2' ?>; color:<?= $sandboxConnected ? '#166534' : '#991b1b' ?>;">
        <i class="fa fa-circle" style="font-size:0.55rem; vertical-align:middle;"></i>
        Sandbox DB: <?= $sandboxConnected ? 'Connected' : 'Not Connected' ?>
    </span>
</div>

<!-- Action Cards -->
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px,1fr)); gap:1rem; margin-bottom:2rem;">
    <!-- Toggle Mode -->
    <div style="background:<?= $sandboxModeActive ? 'linear-gradient(135deg,#f59e0b,#d97706)' : 'white' ?>; border-radius:12px; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.08); text-align:center; <?= $sandboxModeActive ? 'color:white;' : '' ?>">
        <i class="fa fa-toggle-<?= $sandboxModeActive ? 'on' : 'off' ?>" style="font-size:2rem; margin-bottom:0.5rem; color:<?= $sandboxModeActive ? 'white' : '#f59e0b' ?>;"></i>
        <div style="font-weight:700; margin-bottom:0.25rem;">Sandbox Mode</div>
        <div style="font-size:0.8rem; opacity:0.8; margin-bottom:1rem;"><?= $sandboxModeActive ? 'Currently ON' : 'Currently OFF' ?></div>
        <?= $this->Form->create(null, ['url' => ['action' => 'toggleMode']]) ?>
        <?= $this->Form->button($sandboxModeActive ? 'Deactivate' : 'Activate', ['style' => 'width:100%; padding:7px; border-radius:7px; border:1px solid '.($sandboxModeActive ? 'rgba(255,255,255,0.4)' : '#f59e0b').'; background:'.($sandboxModeActive ? 'rgba(255,255,255,0.2)' : '#fef9c3').'; color:'.($sandboxModeActive ? 'white' : '#92400e').'; font-weight:600; cursor:pointer;']) ?>
        <?= $this->Form->end() ?>
    </div>

    <!-- Sync Schema -->
    <div style="background:white; border-radius:12px; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.08); text-align:center;">
        <i class="fa fa-rotate" style="font-size:2rem; margin-bottom:0.5rem; color:#2563eb;"></i>
        <div style="font-weight:700; margin-bottom:0.25rem;">Sync Schema</div>
        <div style="font-size:0.8rem; color:#64748b; margin-bottom:1rem;">Copy prod structure to sandbox</div>
        <?= $this->Form->create(null, ['url' => ['action' => 'syncSchema']]) ?>
        <?= $this->Form->button('Sync Now', ['style' => 'width:100%; padding:7px; border-radius:7px; background:#2563eb; color:white; border:none; font-weight:600; cursor:pointer;', 'onclick' => "return confirm('Copy production schema to sandbox? This will drop and recreate all sandbox tables.');"]) ?>
        <?= $this->Form->end() ?>
    </div>

    <!-- Seed Data -->
    <div style="background:white; border-radius:12px; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.08); text-align:center;">
        <i class="fa fa-seedling" style="font-size:2rem; margin-bottom:0.5rem; color:#16a34a;"></i>
        <div style="font-weight:700; margin-bottom:0.25rem;">Seed Test Data</div>
        <div style="font-size:0.8rem; color:#64748b; margin-bottom:1rem;">Populate sandbox with fake records</div>
        <?= $this->Form->create(null, ['url' => ['action' => 'seedData']]) ?>
        <?= $this->Form->button('Seed Data', ['style' => 'width:100%; padding:7px; border-radius:7px; background:#16a34a; color:white; border:none; font-weight:600; cursor:pointer;']) ?>
        <?= $this->Form->end() ?>
    </div>

    <!-- Reset Sandbox -->
    <div style="background:white; border-radius:12px; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.08); text-align:center;">
        <i class="fa fa-trash-can" style="font-size:2rem; margin-bottom:0.5rem; color:#dc2626;"></i>
        <div style="font-weight:700; margin-bottom:0.25rem;">Reset Sandbox</div>
        <div style="font-size:0.8rem; color:#64748b; margin-bottom:1rem;">Truncate all sandbox tables</div>
        <?= $this->Form->create(null, ['url' => ['action' => 'reset']]) ?>
        <?= $this->Form->button('Reset All', ['style' => 'width:100%; padding:7px; border-radius:7px; background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; font-weight:600; cursor:pointer;', 'onclick' => "return confirm('⚠ This will TRUNCATE ALL sandbox tables. Are you sure?');"]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Table Comparison -->
<?php if ($sandboxConnected && !empty($tableList)): ?>
<div style="background:white; border-radius:12px; padding:1.5rem; box-shadow:0 1px 4px rgba(0,0,0,0.08);">
    <h3 style="font-size:0.9rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; margin-bottom:1rem; border-bottom:2px solid #f1f5f9; padding-bottom:0.5rem;">
        Production vs Sandbox Record Counts
    </h3>
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding:8px 12px; font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; background:#f8fafc; border-bottom:2px solid #e2e8f0;">Table</th>
                <th style="text-align:right; padding:8px 12px; font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; background:#f8fafc; border-bottom:2px solid #e2e8f0;">Production</th>
                <th style="text-align:right; padding:8px 12px; font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; background:#f8fafc; border-bottom:2px solid #e2e8f0;">Sandbox</th>
                <th style="text-align:center; padding:8px 12px; font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px; color:#64748b; background:#f8fafc; border-bottom:2px solid #e2e8f0;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tableList as $row): ?>
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:8px 12px; font-family:monospace; font-size:0.88rem; font-weight:600;"><?= h($row['table']) ?></td>
                <td style="padding:8px 12px; text-align:right;"><?= number_format($row['prod_count']) ?></td>
                <td style="padding:8px 12px; text-align:right;"><?= is_numeric($row['sandbox_count']) ? number_format($row['sandbox_count']) : '<span style="color:#dc2626;">N/A</span>' ?></td>
                <td style="padding:8px 12px; text-align:center;">
                    <?php if ($row['sandbox_count'] === 'N/A'): ?>
                        <span style="color:#dc2626; font-size:0.78rem;">⚠ Missing</span>
                    <?php else: ?>
                        <span style="color:#16a34a; font-size:0.78rem;">✓ Synced</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php elseif (!$sandboxConnected): ?>
<div style="background:#fee2e2; border:1px solid #fca5a5; border-radius:10px; padding:1.25rem 1.5rem; color:#991b1b;">
    <strong><i class="fa fa-triangle-exclamation"></i> Sandbox database not accessible.</strong>
    <p style="margin:0.4rem 0 0; font-size:0.88rem;">Please run <code>migrate_portal_sandbox.php</code> first to create the <code>sandbox</code> database, then use <strong>Sync Schema</strong> above.</p>
</div>
<?php endif; ?>
