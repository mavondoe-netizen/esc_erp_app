<?php
/**
 * @var \App\View\AppView $this
 * @var array $tables
 */
$this->assign('title', 'Manage Models');
?>
<div class="settings-layout">
    <?= $this->element('settings_sidebar') ?>
    <div class="settings-content">
        <div class="dashboard-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2 style="color: var(--color-primary); font-weight: 700; margin: 0;">Dynamic Models</h2>
        <p style="color: var(--color-text-muted); font-size: 0.875rem;">Manage underlying database schema and automatically generate MVC scaffolds.</p>
    </div>
    <div class="header-actions">
        <?= $this->Html->link('Add New Model', ['action' => 'addTable'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<div class="content-card">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Model / Table Name</th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tables as $table): ?>
            <tr>
                <td style="font-weight: 500; font-family: monospace; font-size: 1rem; color: var(--color-text-main);"><?= h($table) ?></td>
                <td class="actions">
                    <?= $this->Html->link('Add Field', ['action' => 'addField', $table], ['class' => 'btn btn-sm btn-outline']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
    </div>
</div>
