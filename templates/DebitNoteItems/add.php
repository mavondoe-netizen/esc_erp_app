<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DebitNoteItem $debitNoteItem
 * @var \Cake\Collection\CollectionInterface|string[] $debitNotes
 * @var \Cake\Collection\CollectionInterface|string[] $products
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Debit Note Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="debitNoteItems form content">
            <?= $this->Form->create($debitNoteItem) ?>
            <fieldset>
                <legend><?= __('Add Debit Note Item') ?></legend>
                <?php
                    echo $this->Form->control('debit_note_id', ['options' => $debitNotes]);
                    echo $this->Form->control('product_id', ['options' => $products, 'empty' => true]);
                    echo $this->Form->control('account_id', ['options' => $accounts]);
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('unit_price');
                    echo $this->Form->control('line_total');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
