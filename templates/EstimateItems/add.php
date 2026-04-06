<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EstimateItem $estimateItem
 * @var \Cake\Collection\CollectionInterface|string[] $estimates
 * @var \Cake\Collection\CollectionInterface|string[] $products
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Estimate Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="estimateItems form content">
            <?= $this->Form->create($estimateItem) ?>
            <fieldset>
                <legend><?= __('Add Estimate Item') ?></legend>
                <?php
                    echo $this->Form->control('estimate_id', ['options' => $estimates]);
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
