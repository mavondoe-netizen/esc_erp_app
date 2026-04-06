<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permission $permission
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Permission'), ['action' => 'edit', $permission->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Permission'), ['action' => 'delete', $permission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permission->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Permissions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Permission'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="permissions view content">
            <h3><?= h($permission->model) ?></h3>
            <table>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $permission->hasValue('role') ? $this->Html->link($permission->role->name, ['controller' => 'Roles', 'action' => 'view', $permission->role->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Model') ?></th>
                    <td><?= h($permission->model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $permission->hasValue('company') ? $this->Html->link($permission->company->name, ['controller' => 'Companies', 'action' => 'view', $permission->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($permission->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($permission->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($permission->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Can Create') ?></th>
                    <td><?= $permission->can_create ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Can Read') ?></th>
                    <td><?= $permission->can_read ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Can Update') ?></th>
                    <td><?= $permission->can_update ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Can Delete') ?></th>
                    <td><?= $permission->can_delete ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Can Approve') ?></th>
                    <td><?= $permission->can_approve ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>