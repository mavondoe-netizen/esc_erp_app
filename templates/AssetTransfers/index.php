<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AssetTransfer> $assetTransfers
 */
?>
<div class="assetTransfers index content">
    <?= $this->Html->link(__('New Asset Transfer'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Asset Transfers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('asset_id') ?></th>
                    <th><?= $this->Paginator->sort('from_office_id') ?></th>
                    <th><?= $this->Paginator->sort('to_office_id') ?></th>
                    <th><?= $this->Paginator->sort('transfer_date') ?></th>
                    <th><?= $this->Paginator->sort('approved_by') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assetTransfers as $assetTransfer): ?>
                <tr>
                    <td><?= $this->Number->format($assetTransfer->id) ?></td>
                    <td><?= $assetTransfer->hasValue('company') ? $this->Html->link($assetTransfer->company->name, ['controller' => 'Companies', 'action' => 'view', $assetTransfer->company->id]) : '' ?></td>
                    <td><?= $assetTransfer->hasValue('asset') ? $this->Html->link($assetTransfer->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetTransfer->asset->id]) : '' ?></td>
                    <td><?= $assetTransfer->from_office_id === null ? '' : $this->Number->format($assetTransfer->from_office_id) ?></td>
                    <td><?= $assetTransfer->to_office_id === null ? '' : $this->Number->format($assetTransfer->to_office_id) ?></td>
                    <td><?= h($assetTransfer->transfer_date) ?></td>
                    <td><?= $assetTransfer->approved_by === null ? '' : $this->Number->format($assetTransfer->approved_by) ?></td>
                    <td><?= h($assetTransfer->status) ?></td>
                    <td><?= h($assetTransfer->created) ?></td>
                    <td><?= h($assetTransfer->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $assetTransfer->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assetTransfer->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assetTransfer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetTransfer->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>