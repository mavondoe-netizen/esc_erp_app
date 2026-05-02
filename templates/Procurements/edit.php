<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Procurement $procurement
 * @var string[]|\Cake\Collection\CollectionInterface $requisitions
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $procurement->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $procurement->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Procurements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="procurements form content">
            <?= $this->Form->create($procurement) ?>
            <fieldset>
                <legend><?= __('Edit Procurement') ?></legend>
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
