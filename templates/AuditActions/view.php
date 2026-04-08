<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditAction $auditAction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Audit Action'), ['action' => 'edit', $auditAction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Audit Action'), ['action' => 'delete', $auditAction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditAction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Audit Actions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Audit Action'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditActions view content">
            <h3><?= h($auditAction->status) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $auditAction->hasValue('company') ? $this->Html->link($auditAction->company->name, ['controller' => 'Companies', 'action' => 'view', $auditAction->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($auditAction->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($auditAction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Finding Id') ?></th>
                    <td><?= $this->Number->format($auditAction->finding_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Assigned To') ?></th>
                    <td><?= $auditAction->assigned_to === null ? '' : $this->Number->format($auditAction->assigned_to) ?></td>
                </tr>
                <tr>
                    <th><?= __('Due Date') ?></th>
                    <td><?= h($auditAction->due_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Completion Date') ?></th>
                    <td><?= h($auditAction->completion_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($auditAction->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($auditAction->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>