<?php
/**
 * Global Admin Settings Sidebar
 * 
 * Included vertically alongside all Admin/Settings screens.
 */
$currentController = $this->request->getParam('controller');
?>
<style>
.settings-layout {
    display: flex;
    gap: 2rem;
    margin-top: 1rem;
}
.settings-sidebar {
    flex: 0 0 250px;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
    height: fit-content;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.settings-sidebar h4 {
    margin-top: 0;
    font-size: 1.1rem;
    border-bottom: 2px solid #eaeaea;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
}
.settings-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}
.settings-menu li {
    margin-bottom: 0.5rem;
}
.settings-menu a {
    display: block;
    padding: 0.5rem 1rem;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
    transition: background 0.2s;
}
.settings-menu a:hover {
    background: #e9ecef;
}
.settings-menu .active a {
    background: var(--primary-color, #007bff);
    color: white;
}
.settings-content {
    flex: 1;
}

/* Ensure mobile layout stacks */
@media (max-width: 768px) {
    .settings-layout {
        flex-direction: column;
    }
    .settings-sidebar {
        flex: 1 1 auto;
    }
}
</style>

<div class="settings-sidebar">
    <h4><?= __('System Settings') ?></h4>
    <ul class="settings-menu">
        <li class="<?= $currentController === 'Settings' ? 'active' : '' ?>">
            <?= $this->Html->link(__('General (NSSA)'), ['controller' => 'Settings', 'action' => 'index']) ?>
        </li>
        <li class="<?= $currentController === 'Modules' ? 'active' : '' ?>">
            <?= $this->Html->link(__('Modules Management'), ['controller' => 'Modules', 'action' => 'index']) ?>
        </li>
        <li class="<?= $currentController === 'Users' ? 'active' : '' ?>">
            <?= $this->Html->link(__('User Management'), ['controller' => 'Users', 'action' => 'index']) ?>
        </li>
        <li class="<?= $currentController === 'Roles' ? 'active' : '' ?>">
            <?= $this->Html->link(__('Roles'), ['controller' => 'Roles', 'action' => 'index']) ?>
        </li>
        <li class="<?= $currentController === 'Permissions' ? 'active' : '' ?>">
            <?= $this->Html->link(__('Permissions'), ['controller' => 'Permissions', 'action' => 'index']) ?>
        </li>
        <li class="<?= $currentController === 'SchemaBuilder' ? 'active' : '' ?>">
            <?= $this->Html->link(__('Schema Builder'), ['controller' => 'SchemaBuilder', 'action' => 'index']) ?>
        </li>
        <li class="<?= $currentController === 'AuditLogs' ? 'active' : '' ?>">
            <?= $this->Html->link(__('Audit Logs'), ['controller' => 'AuditLogs', 'action' => 'index']) ?>
        </li>
        <hr>
        <li class="<?= $currentController === 'LeaveTypes' ? 'active' : '' ?>">
            <?= $this->Html->link(__('Leave Types'), ['controller' => 'LeaveTypes', 'action' => 'index']) ?>
        </li>
        <li class="<?= $currentController === 'LeaveBalances' ? 'active' : '' ?>">
            <?= $this->Html->link(__('Leave Balances'), ['controller' => 'LeaveBalances', 'action' => 'index']) ?>
        </li>
    </ul>
</div>
