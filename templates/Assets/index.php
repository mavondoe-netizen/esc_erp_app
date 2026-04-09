<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Asset> $assets
 */
?>
<div class="assets index content">
    <?= $this->Html->link(__('New Asset'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Assets') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('asset_tag') ?></th>
                    <th><?= $this->Paginator->sort('category_id') ?></th>
                    <th><?= $this->Paginator->sort('classification_id') ?></th>
                    <th><?= $this->Paginator->sort('acquisition_date') ?></th>
                    <th><?= $this->Paginator->sort('acquisition_cost') ?></th>
                    <th><?= $this->Paginator->sort('useful_life') ?></th>
                    <th><?= $this->Paginator->sort('depreciation_method') ?></th>
                    <th><?= $this->Paginator->sort('residual_value') ?></th>
                    <th><?= $this->Paginator->sort('current_book_value') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('office_id') ?></th>
                    <th><?= $this->Paginator->sort('assigned_to') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assets as $asset): ?>
                <tr>
                    <td><?= $this->Number->format($asset->id) ?></td>
                    <td><?= $asset->hasValue('company') ? $this->Html->link($asset->company->name, ['controller' => 'Companies', 'action' => 'view', $asset->company->id]) : '' ?></td>
                    <td><?= h($asset->asset_tag) ?></td>
                    <td><?= $asset->category_id === null ? '' : $this->Number->format($asset->category_id) ?></td>
                    <td><?= $asset->classification_id === null ? '' : $this->Number->format($asset->classification_id) ?></td>
                    <td><?= h($asset->acquisition_date) ?></td>
                    <td><?= $asset->acquisition_cost === null ? '' : $this->Number->format($asset->acquisition_cost) ?></td>
                    <td><?= $asset->useful_life === null ? '' : $this->Number->format($asset->useful_life) ?></td>
                    <td><?= h($asset->depreciation_method) ?></td>
                    <td><?= $this->Number->format($asset->residual_value) ?></td>
                    <td><?= $asset->current_book_value === null ? '' : $this->Number->format($asset->current_book_value) ?></td>
                    <td><?= h($asset->status) ?></td>
                    <td><?= $asset->hasValue('office') ? $this->Html->link($asset->office->name, ['controller' => 'Offices', 'action' => 'view', $asset->office->id]) : '' ?></td>
                    <td><?= $asset->assigned_to === null ? '' : $this->Number->format($asset->assigned_to) ?></td>
                    <td><?= h($asset->created) ?></td>
                    <td><?= h($asset->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $asset->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $asset->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $asset->id], ['confirm' => __('Are you sure you want to delete # {0}?', $asset->id)]) ?>
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