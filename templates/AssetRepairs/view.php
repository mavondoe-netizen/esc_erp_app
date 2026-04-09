<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetRepair $assetRepair
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asset Repair'), ['action' => 'edit', $assetRepair->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asset Repair'), ['action' => 'delete', $assetRepair->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetRepair->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Asset Repairs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asset Repair'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetRepairs view content">
            <h3><?= h($assetRepair->repair_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $assetRepair->hasValue('company') ? $this->Html->link($assetRepair->company->name, ['controller' => 'Companies', 'action' => 'view', $assetRepair->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Asset') ?></th>
                    <td><?= $assetRepair->hasValue('asset') ? $this->Html->link($assetRepair->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetRepair->asset->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Repair Type') ?></th>
                    <td><?= h($assetRepair->repair_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vendor') ?></th>
                    <td><?= h($assetRepair->vendor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($assetRepair->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($assetRepair->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cost') ?></th>
                    <td><?= $this->Number->format($assetRepair->cost) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($assetRepair->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($assetRepair->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($assetRepair->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($assetRepair->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Issue Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($assetRepair->issue_description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>