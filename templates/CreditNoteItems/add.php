<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CreditNoteItem $creditNoteItem
 * @var \Cake\Collection\CollectionInterface|string[] $creditNotes
 * @var \Cake\Collection\CollectionInterface|string[] $products
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Credit Note Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="creditNoteItems form content">
            <?= $this->Form->create($creditNoteItem) ?>
            <fieldset>
                <legend><?= __('Add Credit Note Item') ?></legend>
                <?php
                    echo $this->Form->control('credit_note_id', ['options' => $creditNotes]);
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
