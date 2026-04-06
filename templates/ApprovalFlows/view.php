<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ApprovalFlow $approvalFlow
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Approval Flow'), ['action' => 'edit', $approvalFlow->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Approval Flow'), ['action' => 'delete', $approvalFlow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $approvalFlow->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Approval Flows'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Approval Flow'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvalFlows view content">
            <h3><?= h($approvalFlow->module_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Module Name') ?></th>
                    <td><?= h($approvalFlow->module_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $approvalFlow->hasValue('role') ? $this->Html->link($approvalFlow->role->name, ['controller' => 'Roles', 'action' => 'view', $approvalFlow->role->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($approvalFlow->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($approvalFlow->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= $this->Number->format($approvalFlow->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($approvalFlow->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>