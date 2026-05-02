<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\GoodsReceiptItem> $goodsReceiptItems
 */
?>
<div class="goodsReceiptItems index content">
    <?= $this->Html->link(__('New Goods Receipt Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Goods Receipt Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('goods_receipt_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity_received') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($goodsReceiptItems as $goodsReceiptItem): ?>
                <tr>
                    <td><?= $this->Number->format($goodsReceiptItem->id) ?></td>
                    <td><?= $goodsReceiptItem->hasValue('goods_receipt') ? $this->Html->link($goodsReceiptItem->goods_receipt->id, ['controller' => 'GoodsReceipts', 'action' => 'view', $goodsReceiptItem->goods_receipt->id]) : '' ?></td>
                    <td><?= $this->Number->format($goodsReceiptItem->quantity_received) ?></td>
                    <td><?= $goodsReceiptItem->hasValue('company') ? $this->Html->link($goodsReceiptItem->company->name, ['controller' => 'Companies', 'action' => 'view', $goodsReceiptItem->company->id]) : '' ?></td>
                    <td><?= h($goodsReceiptItem->created) ?></td>
                    <td><?= h($goodsReceiptItem->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $goodsReceiptItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $goodsReceiptItem->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $goodsReceiptItem->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $goodsReceiptItem->id),
                            ]
                        ) ?>
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