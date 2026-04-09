<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssetTransfer $assetTransfer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Asset Transfer'), ['action' => 'edit', $assetTransfer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Asset Transfer'), ['action' => 'delete', $assetTransfer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetTransfer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Asset Transfers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Asset Transfer'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="assetTransfers view content">
            <h3><?= h($assetTransfer->status) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $assetTransfer->hasValue('company') ? $this->Html->link($assetTransfer->company->name, ['controller' => 'Companies', 'action' => 'view', $assetTransfer->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Asset') ?></th>
                    <td><?= $assetTransfer->hasValue('asset') ? $this->Html->link($assetTransfer->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetTransfer->asset->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($assetTransfer->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($assetTransfer->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('From Office Id') ?></th>
                    <td><?= $assetTransfer->from_office_id === null ? '' : $this->Number->format($assetTransfer->from_office_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('To Office Id') ?></th>
                    <td><?= $assetTransfer->to_office_id === null ? '' : $this->Number->format($assetTransfer->to_office_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved By') ?></th>
                    <td><?= $assetTransfer->approved_by === null ? '' : $this->Number->format($assetTransfer->approved_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Transfer Date') ?></th>
                    <td><?= h($assetTransfer->transfer_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($assetTransfer->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($assetTransfer->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>