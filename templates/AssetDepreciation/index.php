<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AssetDepreciation> $assetDepreciation
 */
?>
<div class="assetDepreciation index content">
    <?= $this->Html->link(__('New Asset Depreciation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Asset Depreciation') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('asset_id') ?></th>
                    <th><?= $this->Paginator->sort('period') ?></th>
                    <th><?= $this->Paginator->sort('depreciation_amount') ?></th>
                    <th><?= $this->Paginator->sort('accumulated_depreciation') ?></th>
                    <th><?= $this->Paginator->sort('book_value') ?></th>
                    <th><?= $this->Paginator->sort('posted_to_ledger') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assetDepreciation as $assetDepreciation): ?>
                <tr>
                    <td><?= $this->Number->format($assetDepreciation->id) ?></td>
                    <td><?= $assetDepreciation->hasValue('company') ? $this->Html->link($assetDepreciation->company->name, ['controller' => 'Companies', 'action' => 'view', $assetDepreciation->company->id]) : '' ?></td>
                    <td><?= $assetDepreciation->hasValue('asset') ? $this->Html->link($assetDepreciation->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetDepreciation->asset->id]) : '' ?></td>
                    <td><?= h($assetDepreciation->period) ?></td>
                    <td><?= $this->Number->format($assetDepreciation->depreciation_amount) ?></td>
                    <td><?= $this->Number->format($assetDepreciation->accumulated_depreciation) ?></td>
                    <td><?= $this->Number->format($assetDepreciation->book_value) ?></td>
                    <td><?= h($assetDepreciation->posted_to_ledger) ?></td>
                    <td><?= h($assetDepreciation->created) ?></td>
                    <td><?= h($assetDepreciation->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $assetDepreciation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assetDepreciation->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assetDepreciation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetDepreciation->id)]) ?>
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