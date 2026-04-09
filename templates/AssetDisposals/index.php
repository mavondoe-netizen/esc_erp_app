<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AssetDisposal> $assetDisposals
 */
?>
<div class="assetDisposals index content">
    <?= $this->Html->link(__('New Asset Disposal'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Asset Disposals') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('asset_id') ?></th>
                    <th><?= $this->Paginator->sort('disposal_type') ?></th>
                    <th><?= $this->Paginator->sort('disposal_date') ?></th>
                    <th><?= $this->Paginator->sort('disposal_amount') ?></th>
                    <th><?= $this->Paginator->sort('gain_or_loss') ?></th>
                    <th><?= $this->Paginator->sort('approved_by') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assetDisposals as $assetDisposal): ?>
                <tr>
                    <td><?= $this->Number->format($assetDisposal->id) ?></td>
                    <td><?= $assetDisposal->hasValue('company') ? $this->Html->link($assetDisposal->company->name, ['controller' => 'Companies', 'action' => 'view', $assetDisposal->company->id]) : '' ?></td>
                    <td><?= $assetDisposal->hasValue('asset') ? $this->Html->link($assetDisposal->asset->asset_tag, ['controller' => 'Assets', 'action' => 'view', $assetDisposal->asset->id]) : '' ?></td>
                    <td><?= h($assetDisposal->disposal_type) ?></td>
                    <td><?= h($assetDisposal->disposal_date) ?></td>
                    <td><?= $this->Number->format($assetDisposal->disposal_amount) ?></td>
                    <td><?= $assetDisposal->gain_or_loss === null ? '' : $this->Number->format($assetDisposal->gain_or_loss) ?></td>
                    <td><?= $assetDisposal->approved_by === null ? '' : $this->Number->format($assetDisposal->approved_by) ?></td>
                    <td><?= h($assetDisposal->created) ?></td>
                    <td><?= h($assetDisposal->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $assetDisposal->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assetDisposal->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assetDisposal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetDisposal->id)]) ?>
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