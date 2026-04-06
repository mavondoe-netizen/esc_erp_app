<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receipt $receipt
 * @var string[]|\Cake\Collection\CollectionInterface $suppliers
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 * @var string[]|\Cake\Collection\CollectionInterface $transactions
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $receipt->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $receipt->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Receipts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="receipts form content">
            <?= $this->Form->create($receipt) ?>
            <fieldset>
                <legend><?= __('Edit Receipt') ?></legend>
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
