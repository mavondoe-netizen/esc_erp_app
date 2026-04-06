<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Approval $approval
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Approval'), ['action' => 'edit', $approval->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Approval'), ['action' => 'delete', $approval->id], ['confirm' => __('Are you sure you want to delete # {0}?', $approval->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Approvals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Approval'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvals view content">
            <h3><?= h($approval->table_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Table Name') ?></th>
                    <td><?= h($approval->table_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($approval->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($approval->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entity Id') ?></th>
                    <td><?= $this->Number->format($approval->entity_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Initiated By') ?></th>
                    <td><?= $this->Number->format($approval->initiated_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved By') ?></th>
                    <td><?= $approval->approved_by === null ? '' : $this->Number->format($approval->approved_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($approval->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved At') ?></th>
                    <td><?= h($approval->approved_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Remarks') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($approval->remarks)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>