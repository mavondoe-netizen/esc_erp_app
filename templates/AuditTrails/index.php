<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AuditTrail> $auditTrails
 */
?>
<div class="auditTrails index content">
    <?= $this->Html->link(__('New Audit Trail'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Audit Trails') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('entity_type') ?></th>
                    <th><?= $this->Paginator->sort('entity_id') ?></th>
                    <th><?= $this->Paginator->sort('action') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auditTrails as $auditTrail): ?>
                <tr>
                    <td><?= $this->Number->format($auditTrail->id) ?></td>
                    <td><?= h($auditTrail->entity_type) ?></td>
                    <td><?= $this->Number->format($auditTrail->entity_id) ?></td>
                    <td><?= h($auditTrail->action) ?></td>
                    <td><?= h($auditTrail->description) ?></td>
                    <td><?= $auditTrail->hasValue('user') ? $this->Html->link($auditTrail->user->email, ['controller' => 'Users', 'action' => 'view', $auditTrail->user->id]) : '' ?></td>
                    <td><?= h($auditTrail->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $auditTrail->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $auditTrail->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $auditTrail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditTrail->id)]) ?>
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