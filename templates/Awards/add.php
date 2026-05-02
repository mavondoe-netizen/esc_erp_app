<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Award $award
 * @var \Cake\Collection\CollectionInterface|string[] $tenders
 * @var \Cake\Collection\CollectionInterface|string[] $suppliers
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Awards'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="awards form content">
            <?= $this->Form->create($award) ?>
            <fieldset>
                <legend><?= __('Add Award') ?></legend>
                <?php
                    echo $this->Form->control('tender_id', ['options' => $tenders]);
                    echo $this->Form->control('supplier_id', ['options' => $suppliers]);
                    echo $this->Form->control('awarded_amount');
                    echo $this->Form->control('status');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
