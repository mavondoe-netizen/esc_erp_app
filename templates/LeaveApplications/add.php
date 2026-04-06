<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveApplication $leaveApplication
 * @var \Cake\Collection\CollectionInterface|string[] $employees
 * @var \Cake\Collection\CollectionInterface|string[] $leaveTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Leave Applications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leaveApplications form content">
            <?= $this->Form->create($leaveApplication) ?>
            <fieldset>
                <legend><?= __('Add Leave Application') ?></legend>
                <?php
                    echo $this->Form->control('employee_id', ['options' => $employees]);
                    echo $this->Form->control('leave_type_id', ['options' => $leaveTypes]);
                    echo $this->Form->control('start_date');
                    echo $this->Form->control('end_date');
                    echo $this->Form->control('days_requested');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
