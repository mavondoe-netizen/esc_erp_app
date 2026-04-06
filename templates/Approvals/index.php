<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Approval> $approvals
 */
?>
<div class="approvals index content">
    <?= $this->Html->link(__('New Approval'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Approvals') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('table_name') ?></th>
                    <th><?= $this->Paginator->sort('entity_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('initiated_by') ?></th>
                    <th><?= $this->Paginator->sort('approved_by') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('approved_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($approvals as $approval): ?>
                <tr>
                    <td><?= $this->Number->format($approval->id) ?></td>
                    <td><?= h($approval->table_name) ?></td>
                    <td><?= $this->Number->format($approval->entity_id) ?></td>
                    <td><?= h($approval->status) ?></td>
                    <td><?= $this->Number->format($approval->initiated_by) ?></td>
                    <td><?= $approval->approved_by === null ? '' : $this->Number->format($approval->approved_by) ?></td>
                    <td><?= h($approval->created) ?></td>
                    <td><?= h($approval->approved_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $approval->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $approval->id]) ?>
                        <?= $this->Html->link(__('Approve'), ['action' => 'approve', $approval->id]) ?>
                        <?= $this->Html->link(__('Reject'), ['action' => 'reject', $approval->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $approval->id], ['confirm' => __('Are you sure you want to delete # {0}?', $approval->id)]) ?>
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