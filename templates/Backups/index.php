<?php
/**
 * @var \App\View\AppView $this
 * @var array $backups
 */
?>
<div class="backups index content">
    <div class="index-header">
        <h2 class="index-title"><i class="fas fa-database"></i> Database Backups</h2>
        <div class="actions">
            <?= $this->Html->link(__('<i class="fas fa-plus"></i> Create New Backup'), ['action' => 'create'], ['class' => 'button', 'escape' => false]) ?>
        </div>
    </div>

    <div class="stats-summary" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-value"><?= count($backups) ?></div>
            <div class="stat-label">Total Backups Available</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><i class="fas fa-hdd"></i></div>
            <div class="stat-label">Location: tmp/backups/</div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="backups-table" class="table hover-rows">
            <thead>
                <tr>
                    <th>Filename</th>
                    <th>Size (MB)</th>
                    <th>Created At</th>
                    <th class="actions no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($backups as $backup): ?>
                    <tr>
                        <td class="primary-text">
                            <i class="fas fa-file-invoice" style="margin-right: 0.5rem; color: #444;"></i>
                            <?= h($backup['name']) ?>
                        </td>
                        <td><?= h($backup['size']) ?> MB</td>
                        <td><?= h($backup['created']) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('<i class="fas fa-download"></i>'), ['action' => 'download', $backup['name']], ['class' => 'action-icon edit', 'title' => 'Download', 'escape' => false]) ?>
                            <?= $this->Form->postLink(__('<i class="fas fa-trash"></i>'), ['action' => 'delete', $backup['name']], ['confirm' => __('Are you sure you want to delete {0}?', $backup['name']), 'class' => 'action-icon delete', 'title' => 'Delete', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="alert-info" style="margin-top: 2rem; padding: 1.5rem; background: #f0f7ff; border-radius: 8px; border-left: 4px solid #007bff;">
        <h4 style="margin-top: 0; color: #004a99;"><i class="fas fa-info-circle"></i> Best Practices</h4>
        <ul style="margin: 0; padding-left: 1.5rem; color: #444;">
            <li>Daily backups are highly recommended before making major changes.</li>
            <li>Backups are stored locally. For maximum security, download them and store them in an external or cloud drive.</li>
            <li>Restoring from backup requires a database management tool like phpMyAdmin or HeidiSQL.</li>
        </ul>
    </div>
</div>

<style>
.index-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}
.index-title {
    margin: 0;
    font-weight: 700;
}
.stats-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}
.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    text-align: center;
    border-bottom: 3px solid #007bff;
}
.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #222;
}
.stat-label {
    font-size: 0.9rem;
    color: #666;
    text-transform: uppercase;
}
.action-icon {
    font-size: 1.1rem;
    padding: 8px;
    border-radius: 4px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.action-icon:hover {
    transform: translateY(-2px);
}
.action-icon.edit { color: #007bff; }
.action-icon.delete { color: #dc3545; }
.primary-text {
    font-weight: 600;
}
</style>
