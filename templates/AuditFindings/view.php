<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditFinding $auditFinding
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Audit Finding'), ['action' => 'edit', $auditFinding->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Audit Finding'), ['action' => 'delete', $auditFinding->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditFinding->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Audit Findings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Audit Finding'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditFindings view content">
            <h3><?= h($auditFinding->risk_level) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $auditFinding->hasValue('company') ? $this->Html->link($auditFinding->company->name, ['controller' => 'Companies', 'action' => 'view', $auditFinding->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Audit') ?></th>
                    <td><?= $auditFinding->hasValue('audit') ? $this->Html->link($auditFinding->audit->title, ['controller' => 'Audits', 'action' => 'view', $auditFinding->audit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Risk Level') ?></th>
                    <td><?= h($auditFinding->risk_level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($auditFinding->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($auditFinding->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($auditFinding->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($auditFinding->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Finding') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($auditFinding->finding)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Root Cause') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($auditFinding->root_cause)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Recommendation') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($auditFinding->recommendation)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Management Response') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($auditFinding->management_response)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>