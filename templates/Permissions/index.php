<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Permission> $permissions
 */
?>
<div class="permissions index content">
    <?= $this->Html->link(__('New Permission'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Permissions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('role_id') ?></th>
                    <th><?= $this->Paginator->sort('model') ?></th>
                    <th><?= $this->Paginator->sort('can_create') ?></th>
                    <th><?= $this->Paginator->sort('can_read') ?></th>
                    <th><?= $this->Paginator->sort('can_update') ?></th>
                    <th><?= $this->Paginator->sort('can_delete') ?></th>
                    <th><?= $this->Paginator->sort('can_approve') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($permissions as $permission): ?>
                <tr>
                    <td><?= $this->Number->format($permission->id) ?></td>
                    <td><?= $permission->hasValue('role') ? $this->Html->link($permission->role->name, ['controller' => 'Roles', 'action' => 'view', $permission->role->id]) : '' ?></td>
                    <td><?= h($permission->model) ?></td>
                    <td><?= h($permission->can_create) ?></td>
                    <td><?= h($permission->can_read) ?></td>
                    <td><?= h($permission->can_update) ?></td>
                    <td><?= h($permission->can_delete) ?></td>
                    <td><?= h($permission->can_approve) ?></td>
                    <td><?= h($permission->created) ?></td>
                    <td><?= h($permission->modified) ?></td>
                    <td><?= $permission->hasValue('company') ? $this->Html->link($permission->company->name, ['controller' => 'Companies', 'action' => 'view', $permission->company->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $permission->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $permission->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $permission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permission->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>