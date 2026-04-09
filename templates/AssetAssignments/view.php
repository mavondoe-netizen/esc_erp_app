<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetAssignment $assetAssignment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asset Assignment'), ['action' => 'edit', $assetAssignment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asset Assignment'), ['action' => 'delete', $assetAssignment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetAssignment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Asset Assignments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asset Assignment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetAssignments view content">
            <h3><?= h($assetAssignment->status) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $assetAssignment->hasValue('company') ? $this->Html->link($assetAssignment->company->name, ['controller' => 'Companies', 'action' => 'view', $assetAssignment->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Asset') ?></th>
                    <td><?= $assetAssignment->hasValue('asset') ? $this->Html->link($assetAssignment->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetAssignment->asset->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Office') ?></th>
                    <td><?= $assetAssignment->hasValue('office') ? $this->Html->link($assetAssignment->office->name, ['controller' => 'Offices', 'action' => 'view', $assetAssignment->office->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Department') ?></th>
                    <td><?= $assetAssignment->hasValue('department') ? $this->Html->link($assetAssignment->department->name, ['controller' => 'Departments', 'action' => 'view', $assetAssignment->department->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($assetAssignment->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($assetAssignment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Assigned To') ?></th>
                    <td><?= $assetAssignment->assigned_to === null ? '' : $this->Number->format($assetAssignment->assigned_to) ?></td>
                </tr>
                <tr>
                    <th><?= __('Assigned Date') ?></th>
                    <td><?= h($assetAssignment->assigned_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($assetAssignment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($assetAssignment->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>