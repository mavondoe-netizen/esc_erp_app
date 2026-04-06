<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ApprovalFlow> $approvalFlows
 */
?>
<div class="approvalFlows index content">
    <?= $this->Html->link(__('New Approval Flow'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Approval Flows') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('module_name') ?></th>
                    <th><?= $this->Paginator->sort('level') ?></th>
                    <th><?= $this->Paginator->sort('role_id') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($approvalFlows as $approvalFlow): ?>
                <tr>
                    <td><?= $this->Number->format($approvalFlow->id) ?></td>
                    <td><?= h($approvalFlow->module_name) ?></td>
                    <td><?= $this->Number->format($approvalFlow->level) ?></td>
                    <td><?= $approvalFlow->hasValue('role') ? $this->Html->link($approvalFlow->role->name, ['controller' => 'Roles', 'action' => 'view', $approvalFlow->role->id]) : '' ?></td>
                    <td><?= h($approvalFlow->description) ?></td>
                    <td><?= h($approvalFlow->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $approvalFlow->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $approvalFlow->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $approvalFlow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $approvalFlow->id)]) ?>
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