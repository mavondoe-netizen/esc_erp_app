<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EstimateItem $estimateItem
 * @var string[]|\Cake\Collection\CollectionInterface $estimates
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
                ['action' => 'delete', $estimateItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $estimateItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Estimate Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="estimateItems form content">
            <?= $this->Form->create($estimateItem) ?>
            <fieldset>
                <legend><?= __('Edit Estimate Item') ?></legend>
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
