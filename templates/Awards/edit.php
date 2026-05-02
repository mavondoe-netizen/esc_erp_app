<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Award $award
 * @var string[]|\Cake\Collection\CollectionInterface $tenders
 * @var string[]|\Cake\Collection\CollectionInterface $suppliers
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $award->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $award->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Awards'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="awards form content">
            <?= $this->Form->create($award) ?>
            <fieldset>
                <legend><?= __('Edit Award') ?></legend>
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
