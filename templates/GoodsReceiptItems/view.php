<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GoodsReceiptItem $goodsReceiptItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Goods Receipt Item'), ['action' => 'edit', $goodsReceiptItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Goods Receipt Item'), ['action' => 'delete', $goodsReceiptItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $goodsReceiptItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Goods Receipt Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Goods Receipt Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="goodsReceiptItems view content">
            <h3><?= h($goodsReceiptItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Goods Receipt') ?></th>
                    <td><?= $goodsReceiptItem->hasValue('goods_receipt') ? $this->Html->link($goodsReceiptItem->goods_receipt->id, ['controller' => 'GoodsReceipts', 'action' => 'view', $goodsReceiptItem->goods_receipt->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $goodsReceiptItem->hasValue('company') ? $this->Html->link($goodsReceiptItem->company->name, ['controller' => 'Companies', 'action' => 'view', $goodsReceiptItem->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($goodsReceiptItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity Received') ?></th>
                    <td><?= $this->Number->format($goodsReceiptItem->quantity_received) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($goodsReceiptItem->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($goodsReceiptItem->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($goodsReceiptItem->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>