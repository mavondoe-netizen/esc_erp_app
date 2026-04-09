<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AssetCategory> $assetCategories
 */
?>
<div class="assetCategories index content">
    <?= $this->Html->link(__('New Asset Category'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Asset Categories') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('default_useful_life') ?></th>
                    <th><?= $this->Paginator->sort('depreciation_method') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assetCategories as $assetCategory): ?>
                <tr>
                    <td><?= $this->Number->format($assetCategory->id) ?></td>
                    <td><?= $assetCategory->hasValue('company') ? $this->Html->link($assetCategory->company->name, ['controller' => 'Companies', 'action' => 'view', $assetCategory->company->id]) : '' ?></td>
                    <td><?= h($assetCategory->name) ?></td>
                    <td><?= $assetCategory->default_useful_life === null ? '' : $this->Number->format($assetCategory->default_useful_life) ?></td>
                    <td><?= h($assetCategory->depreciation_method) ?></td>
                    <td><?= h($assetCategory->created) ?></td>
                    <td><?= h($assetCategory->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $assetCategory->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assetCategory->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assetCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetCategory->id)]) ?>
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