<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requisition $requisition
 * @var string[]|\Cake\Collection\CollectionInterface $departments
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
                ['action' => 'delete', $requisition->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $requisition->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Requisitions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="requisitions form content">
            <?= $this->Form->create($requisition) ?>
            <fieldset>
                <legend><?= __('Edit Requisition') ?></legend>
                <?php
                    echo $this->Form->control('department_id', ['options' => $departments]);
                    echo $this->Form->control('requested_by', ['options' => $users]);
                    echo $this->Form->control('description');
                    echo $this->Form->control('total_estimated_cost');
                    echo $this->Form->control('status');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
