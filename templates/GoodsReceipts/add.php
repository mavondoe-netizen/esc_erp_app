<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GoodsReceipt $goodsReceipt
 * @var \Cake\Collection\CollectionInterface|string[] $contracts
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Goods Receipts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="goodsReceipts form content">
            <?= $this->Form->create($goodsReceipt) ?>
            <fieldset>
                <legend><?= __('Add Goods Receipt') ?></legend>
                <?php
                    echo $this->Form->control('contract_id', ['options' => $contracts]);
                    echo $this->Form->control('received_by', ['options' => $users]);
                    echo $this->Form->control('received_date');
                    echo $this->Form->control('status');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
