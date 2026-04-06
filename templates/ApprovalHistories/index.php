<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ApprovalHistory> $approvalHistories
 */
?>
<div class="approvalHistories index content">
    <?= $this->Html->link(__('New Approval History'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Approval Histories') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('approval_id') ?></th>
                    <th><?= $this->Paginator->sort('action') ?></th>
                    <th><?= $this->Paginator->sort('level') ?></th>
                    <th><?= $this->Paginator->sort('performed_by') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($approvalHistories as $approvalHistory): ?>
                <tr>
                    <td><?= $this->Number->format($approvalHistory->id) ?></td>
                    <td><?= $approvalHistory->hasValue('approval') ? $this->Html->link($approvalHistory->approval->table_name, ['controller' => 'Approvals', 'action' => 'view', $approvalHistory->approval->id]) : '' ?></td>
                    <td><?= h($approvalHistory->action) ?></td>
                    <td><?= $approvalHistory->level === null ? '' : $this->Number->format($approvalHistory->level) ?></td>
                    <td><?= $approvalHistory->performed_by === null ? '' : $this->Number->format($approvalHistory->performed_by) ?></td>
                    <td><?= h($approvalHistory->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $approvalHistory->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $approvalHistory->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $approvalHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $approvalHistory->id)]) ?>
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