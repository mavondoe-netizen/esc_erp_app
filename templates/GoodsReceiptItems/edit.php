<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GoodsReceiptItem $goodsReceiptItem
 * @var string[]|\Cake\Collection\CollectionInterface $goodsReceipts
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $goodsReceiptItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $goodsReceiptItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Goods Receipt Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="goodsReceiptItems form content">
            <?= $this->Form->create($goodsReceiptItem) ?>
            <fieldset>
                <legend><?= __('Edit Goods Receipt Item') ?></legend>
                <?php
                    echo $this->Form->control('goods_receipt_id', ['options' => $goodsReceipts]);
                    echo $this->Form->control('description');
                    echo $this->Form->control('quantity_received');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
