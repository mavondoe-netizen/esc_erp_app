<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ApprovalHistory $approvalHistory
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Approval History'), ['action' => 'edit', $approvalHistory->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Approval History'), ['action' => 'delete', $approvalHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $approvalHistory->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Approval Histories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Approval History'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="approvalHistories view content">
            <h3><?= h($approvalHistory->action) ?></h3>
            <table>
                <tr>
                    <th><?= __('Approval') ?></th>
                    <td><?= $approvalHistory->hasValue('approval') ? $this->Html->link($approvalHistory->approval->table_name, ['controller' => 'Approvals', 'action' => 'view', $approvalHistory->approval->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Action') ?></th>
                    <td><?= h($approvalHistory->action) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($approvalHistory->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= $approvalHistory->level === null ? '' : $this->Number->format($approvalHistory->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Performed By') ?></th>
                    <td><?= $approvalHistory->performed_by === null ? '' : $this->Number->format($approvalHistory->performed_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($approvalHistory->created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Remarks') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($approvalHistory->remarks)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>