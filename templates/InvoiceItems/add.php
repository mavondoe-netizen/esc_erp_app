<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceItem $invoiceItem
 * @var \Cake\Collection\CollectionInterface|string[] $invoices
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 * @var \Cake\Collection\CollectionInterface|string[] $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Invoice Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoiceItems form content">
            <?= $this->Form->create($invoiceItem) ?>
            <fieldset>
                <legend><?= __('Add Invoice Item') ?></legend>
                <?php
                    echo $this->Form->control('invoice_id', ['options' => $invoices]);
                    echo $this->Form->control('account_id', ['options' => $accounts]);
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('unit_price');
                    echo $this->Form->control('line_total');
                    echo $this->Form->control('product_id', ['options' => $products, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
