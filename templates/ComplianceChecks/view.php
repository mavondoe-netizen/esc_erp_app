<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ComplianceCheck $complianceCheck
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Compliance Check'), ['action' => 'edit', $complianceCheck->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Compliance Check'), ['action' => 'delete', $complianceCheck->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complianceCheck->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Compliance Checks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Compliance Check'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="complianceChecks view content">
            <h3><?= h($complianceCheck->status) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $complianceCheck->hasValue('company') ? $this->Html->link($complianceCheck->company->name, ['controller' => 'Companies', 'action' => 'view', $complianceCheck->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($complianceCheck->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($complianceCheck->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Obligation Id') ?></th>
                    <td><?= $this->Number->format($complianceCheck->obligation_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Checked At') ?></th>
                    <td><?= h($complianceCheck->checked_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($complianceCheck->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($complianceCheck->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Evidence') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($complianceCheck->evidence)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>