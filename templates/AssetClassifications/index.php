<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AssetClassification> $assetClassifications
 */
?>
<div class="assetClassifications index content">
    <?= $this->Html->link(__('New Asset Classification'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Asset Classifications') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assetClassifications as $assetClassification): ?>
                <tr>
                    <td><?= $this->Number->format($assetClassification->id) ?></td>
                    <td><?= $assetClassification->hasValue('company') ? $this->Html->link($assetClassification->company->name, ['controller' => 'Companies', 'action' => 'view', $assetClassification->company->id]) : '' ?></td>
                    <td><?= h($assetClassification->type) ?></td>
                    <td><?= h($assetClassification->created) ?></td>
                    <td><?= h($assetClassification->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $assetClassification->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assetClassification->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assetClassification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assetClassification->id)]) ?>
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