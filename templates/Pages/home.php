<?php
/**
 * @var \App\View\AppView $this
 * @var array|null $dashboardStats
 */

// If $dashboardStats is not set (e.g., debug enabled / cache issues), provide defaults.
if (!isset($dashboardStats)) {
    $dashboardStats = [];
}

$this->assign('title', 'Dashboard');
?>

<div class="dashboard-header" style="margin-bottom: 2rem;">
    <h2 style="color: var(--color-primary); font-weight: 700; margin: 0;">Dashboard Overview</h2>
    <p style="color: var(--color-text-muted); font-size: 0.875rem;">Welcome to the Eras App ERP. Here's what's happening today.</p>
</div>

<div class="dashboard-grid">
    <?php foreach ($dashboardStats as $modelName => $count): ?>
        <a href="<?= $this->Url->build('/' . strtolower($modelName)) ?>" class="stat-card">
            <div class="stat-card-title"><?= h($modelName) ?></div>
            <div class="stat-card-value"><?= number_format($count) ?></div>
        </a>
    <?php endforeach; ?>
</div>

<!-- Quick Actions -->
<div class="dashboard-actions" style="margin-top: 3rem;">
    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Quick Actions</h3>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <?= $this->Html->link('+ New Customer', ['controller' => 'Customers', 'action' => 'add'], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link('+ New Deal', ['controller' => 'Deals', 'action' => 'add'], ['class' => 'btn btn-success']) ?>
        <?= $this->Html->link('+ Add Invoice', ['controller' => 'Invoices', 'action' => 'add'], ['class' => 'btn btn-primary', 'style' => 'background-color: var(--color-text-main);']) ?>
    </div>
</div>
