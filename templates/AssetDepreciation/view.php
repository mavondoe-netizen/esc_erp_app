<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetDepreciation $assetDepreciation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asset Depreciation'), ['action' => 'edit', $assetDepreciation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asset Depreciation'), ['action' => 'delete', $assetDepreciation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetDepreciation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Asset Depreciation'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asset Depreciation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetDepreciation view content">
            <h3><?= h($assetDepreciation->period) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $assetDepreciation->hasValue('company') ? $this->Html->link($assetDepreciation->company->name, ['controller' => 'Companies', 'action' => 'view', $assetDepreciation->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Asset') ?></th>
                    <td><?= $assetDepreciation->hasValue('asset') ? $this->Html->link($assetDepreciation->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetDepreciation->asset->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Period') ?></th>
                    <td><?= h($assetDepreciation->period) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($assetDepreciation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Depreciation Amount') ?></th>
                    <td><?= $this->Number->format($assetDepreciation->depreciation_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Accumulated Depreciation') ?></th>
                    <td><?= $this->Number->format($assetDepreciation->accumulated_depreciation) ?></td>
                </tr>
                <tr>
                    <th><?= __('Book Value') ?></th>
                    <td><?= $this->Number->format($assetDepreciation->book_value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($assetDepreciation->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($assetDepreciation->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Posted To Ledger') ?></th>
                    <td><?= $assetDepreciation->posted_to_ledger ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>