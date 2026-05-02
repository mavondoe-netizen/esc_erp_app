<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AuditLog> $auditLogs
 */
?>
<div class="auditLogs index content">
    <?= $this->Html->link(__('New Audit Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Audit Logs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('model') ?></th>
                    <th><?= $this->Paginator->sort('record_id') ?></th>
                    <th><?= $this->Paginator->sort('action') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auditLogs as $auditLog): ?>
                <tr>
                    <td><?= $this->Number->format($auditLog->id) ?></td>
                    <td>
                        <?= $auditLog->user_id ?>
                        <?php if (!empty($usersMap[$auditLog->user_id])): ?>
                            (<?= $this->Html->link($usersMap[$auditLog->user_id]->email, ['controller' => 'Users', 'action' => 'view', $auditLog->user_id]) ?>)
                        <?php endif; ?>
                    </td>
                    <td><?= h($auditLog->model) ?></td>
                    <td><?= h($auditLog->record_id) ?></td>
                    <td><?= h($auditLog->action) ?></td>
                    <td><?= h($auditLog->created) ?></td>
                    <td><?= $auditLog->hasValue('company') ? $this->Html->link($auditLog->company->name, ['controller' => 'Companies', 'action' => 'view', $auditLog->company->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $auditLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $auditLog->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $auditLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditLog->id)]) ?>
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