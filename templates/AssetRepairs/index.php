<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AssetRepair> $assetRepairs
 */
?>
<div class="assetRepairs index content">
    <?= $this->Html->link(__('New Asset Repair'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Asset Repairs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('asset_id') ?></th>
                    <th><?= $this->Paginator->sort('repair_type') ?></th>
                    <th><?= $this->Paginator->sort('vendor') ?></th>
                    <th><?= $this->Paginator->sort('cost') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assetRepairs as $assetRepair): ?>
                <tr>
                    <td><?= $this->Number->format($assetRepair->id) ?></td>
                    <td><?= $assetRepair->hasValue('company') ? $this->Html->link($assetRepair->company->name, ['controller' => 'Companies', 'action' => 'view', $assetRepair->company->id]) : '' ?></td>
                    <td><?= $assetRepair->hasValue('asset') ? $this->Html->link($assetRepair->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetRepair->asset->id]) : '' ?></td>
                    <td><?= h($assetRepair->repair_type) ?></td>
                    <td><?= h($assetRepair->vendor) ?></td>
                    <td><?= $this->Number->format($assetRepair->cost) ?></td>
                    <td><?= h($assetRepair->start_date) ?></td>
                    <td><?= h($assetRepair->end_date) ?></td>
                    <td><?= h($assetRepair->status) ?></td>
                    <td><?= h($assetRepair->created) ?></td>
                    <td><?= h($assetRepair->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $assetRepair->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assetRepair->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assetRepair->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetRepair->id)]) ?>
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