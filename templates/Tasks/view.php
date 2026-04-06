<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Task'), ['action' => 'edit', $task->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Task'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tasks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Task'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tasks view content">
            <h3><?= h($task->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($task->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($task->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $task->hasValue('user') ? $this->Html->link($task->user->role_id, ['controller' => 'Users', 'action' => 'view', $task->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $task->hasValue('company') ? $this->Html->link($task->company->name, ['controller' => 'Companies', 'action' => 'view', $task->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($task->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>