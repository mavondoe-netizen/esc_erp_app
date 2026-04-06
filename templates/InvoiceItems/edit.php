<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceItem $invoiceItem
 * @var string[]|\Cake\Collection\CollectionInterface $invoices
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $invoiceItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Invoice Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoiceItems form content">
            <?= $this->Form->create($invoiceItem) ?>
            <fieldset>
                <legend><?= __('Edit Invoice Item') ?></legend>
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
