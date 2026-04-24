<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LevyItem $levyItem
 * @var \Cake\Collection\CollectionInterface|array $levies
 * @var \Cake\Collection\CollectionInterface|array $accounts
 * @var \Cake\Collection\CollectionInterface|array $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $levyItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $levyItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Levy Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="levyItems form content">
            <?= $this->Form->create($levyItem) ?>
            <fieldset>
                <legend><?= __('Edit Levy Item') ?></legend>
                <div class="row">
                    <div class="column">
                        <?= $this->Form->control('levy_id', ['options' => $levies, 'empty' => '-- Select Levy --', 'label' => 'Levy']) ?>
                        <?= $this->Form->control('account_id', ['options' => $accounts, 'empty' => '-- Select Account --', 'label' => 'Account']) ?>
                        <?= $this->Form->control('product_id', ['options' => $products, 'empty' => '-- Select Product (optional) --', 'label' => 'Product']) ?>
                        <?= $this->Form->control('description', ['type' => 'textarea', 'rows' => 2]) ?>
                    </div>
                    <div class="column">
                        <?= $this->Form->control('quantity', ['type' => 'number', 'min' => '1']) ?>
                        <?= $this->Form->control('unit_price', ['type' => 'number', 'step' => '0.01', 'label' => 'Unit Price']) ?>
                        <?= $this->Form->control('line_total', ['type' => 'number', 'step' => '0.01', 'label' => 'Line Total']) ?>
                        <?= $this->Form->control('vat_rate', ['type' => 'number', 'step' => '0.01', 'label' => 'VAT Rate (%)']) ?>
                        <?= $this->Form->control('vat_amount', ['type' => 'number', 'step' => '0.01', 'label' => 'VAT Amount']) ?>
                        <?= $this->Form->control('vat_type', ['label' => 'VAT Type']) ?>
                        <?= $this->Form->control('hs_code', ['label' => 'HS Code']) ?>
                    </div>
                </div>
            </fieldset>
            <?= $this->Form->button(__('Save Levy Item'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
