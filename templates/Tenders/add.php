<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tender $tender
 * @var \Cake\Collection\CollectionInterface|string[] $procurements
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tenders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tenders form content">
            <?= $this->Form->create($tender) ?>
            <fieldset>
                <legend><?= __('Add Tender') ?></legend>
                <?php
                    echo $this->Form->control('procurement_id', ['options' => $procurements]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('closing_date', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
