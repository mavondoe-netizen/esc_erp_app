<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ApprovalLevel $approvalLevel
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Approval Level'), ['action' => 'edit', $approvalLevel->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Approval Level'), ['action' => 'delete', $approvalLevel->id], ['confirm' => __('Are you sure you want to delete # {0}?', $approvalLevel->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Approval Levels'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Approval Level'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvalLevels view content">
            <h3><?= h($approvalLevel->entity) ?></h3>
            <table>
                <tr>
                    <th><?= __('Entity') ?></th>
                    <td><?= h($approvalLevel->entity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($approvalLevel->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($approvalLevel->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= $this->Number->format($approvalLevel->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Min Value') ?></th>
                    <td><?= $approvalLevel->min_value === null ? '' : $this->Number->format($approvalLevel->min_value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($approvalLevel->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($approvalLevel->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>