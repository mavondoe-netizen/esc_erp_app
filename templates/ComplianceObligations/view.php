<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ComplianceObligation $complianceObligation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Compliance Obligation'), ['action' => 'edit', $complianceObligation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Compliance Obligation'), ['action' => 'delete', $complianceObligation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $complianceObligation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Compliance Obligations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Compliance Obligation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="complianceObligations view content">
            <h3><?= h($complianceObligation->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $complianceObligation->hasValue('company') ? $this->Html->link($complianceObligation->company->name, ['controller' => 'Companies', 'action' => 'view', $complianceObligation->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Regulation') ?></th>
                    <td><?= $complianceObligation->hasValue('regulation') ? $this->Html->link($complianceObligation->regulation->name, ['controller' => 'Regulations', 'action' => 'view', $complianceObligation->regulation->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Frequency') ?></th>
                    <td><?= h($complianceObligation->frequency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($complianceObligation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Owner Id') ?></th>
                    <td><?= $complianceObligation->owner_id === null ? '' : $this->Number->format($complianceObligation->owner_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($complianceObligation->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($complianceObligation->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Requirement') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($complianceObligation->requirement)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>