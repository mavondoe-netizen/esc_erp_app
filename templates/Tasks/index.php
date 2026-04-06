<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Task> $tasks
 */
?>
<div class="tasks index content">
    <?= $this->Html->link(__('New Task'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tasks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= $this->Number->format($task->id) ?></td>
                    <td><?= h($task->name) ?></td>
                    <td><?= h($task->description) ?></td>
                    <td><?= $task->hasValue('user') ? $this->Html->link($task->user->role_id, ['controller' => 'Users', 'action' => 'view', $task->user->id]) : '' ?></td>
                    <td><?= $task->hasValue('company') ? $this->Html->link($task->company->name, ['controller' => 'Companies', 'action' => 'view', $task->company->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $task->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $task->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]) ?>
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