<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CreditNoteItem $creditNoteItem
 * @var string[]|\Cake\Collection\CollectionInterface $creditNotes
 * @var string[]|\Cake\Collection\CollectionInterface $products
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $creditNoteItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $creditNoteItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Credit Note Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="creditNoteItems form content">
            <?= $this->Form->create($creditNoteItem) ?>
            <fieldset>
                <legend><?= __('Edit Credit Note Item') ?></legend>
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
