<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requisition $requisition
 * @var \Cake\Collection\CollectionInterface|string[] $departments
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Requisitions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="requisitions form content">
            <?= $this->Form->create($requisition) ?>
            <fieldset>
                <legend><?= __('Add Requisition') ?></legend>
                <?php
                    echo $this->Form->control('department_id', ['options' => $departments]);
                    echo $this->Form->control('requested_by', ['options' => $users]);
                    echo $this->Form->control('manual_reference', ['label' => 'Manual Ref / Serial No.']);
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
