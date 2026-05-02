<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GoodsReceiptItem $goodsReceiptItem
 * @var \Cake\Collection\CollectionInterface|string[] $goodsReceipts
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Goods Receipt Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="goodsReceiptItems form content">
            <?= $this->Form->create($goodsReceiptItem) ?>
            <fieldset>
                <legend><?= __('Add Goods Receipt Item') ?></legend>
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
