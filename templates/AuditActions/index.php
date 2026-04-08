<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AuditAction> $auditActions
 */
?>
<div class="auditActions index content">
    <?= $this->Html->link(__('New Audit Action'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Audit Actions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('finding_id') ?></th>
                    <th><?= $this->Paginator->sort('assigned_to') ?></th>
                    <th><?= $this->Paginator->sort('due_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('completion_date') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auditActions as $auditAction): ?>
                <tr>
                    <td><?= $this->Number->format($auditAction->id) ?></td>
                    <td><?= $auditAction->hasValue('company') ? $this->Html->link($auditAction->company->name, ['controller' => 'Companies', 'action' => 'view', $auditAction->company->id]) : '' ?></td>
                    <td><?= $this->Number->format($auditAction->finding_id) ?></td>
                    <td><?= $auditAction->assigned_to === null ? '' : $this->Number->format($auditAction->assigned_to) ?></td>
                    <td><?= h($auditAction->due_date) ?></td>
                    <td><?= h($auditAction->status) ?></td>
                    <td><?= h($auditAction->completion_date) ?></td>
                    <td><?= h($auditAction->created) ?></td>
                    <td><?= h($auditAction->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $auditAction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $auditAction->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $auditAction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditAction->id)]) ?>
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