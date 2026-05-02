<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Procurement $procurement
 * @var \Cake\Collection\CollectionInterface|string[] $requisitions
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Procurements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="procurements form content">
            <?= $this->Form->create($procurement) ?>
            <fieldset>
                <legend><?= __('Add Procurement') ?></legend>
                <?php
                    echo $this->Form->control('requisition_id', ['options' => $requisitions]);
                    echo $this->Form->control('procurement_method');
                    echo $this->Form->control('assigned_to', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
