<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RequisitionItem $requisitionItem
 * @var \Cake\Collection\CollectionInterface|string[] $requisitions
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Requisition Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="requisitionItems form content">
            <?= $this->Form->create($requisitionItem) ?>
            <fieldset>
                <legend><?= __('Add Requisition Item') ?></legend>
                <?php
                    echo $this->Form->control('requisition_id', ['options' => $requisitions]);
                    echo $this->Form->control('item_description');
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('estimated_unit_price');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
