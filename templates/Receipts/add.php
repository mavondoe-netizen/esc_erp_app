<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receipt $receipt
 * @var \Cake\Collection\CollectionInterface|string[] $suppliers
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 * @var \Cake\Collection\CollectionInterface|string[] $transactions
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Receipts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="receipts form content">
            <?= $this->Form->create($receipt) ?>
            <fieldset>
                <legend><?= __('Add Receipt') ?></legend>
                <?php
                    echo $this->Form->control('supplier_id', ['options' => $suppliers]);
                    echo $this->Form->control('currency');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
                    echo $this->Form->control('transactions._ids', ['options' => $transactions]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
