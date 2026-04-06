<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveApplication $leaveApplication
 * @var string[]|\Cake\Collection\CollectionInterface $employees
 * @var string[]|\Cake\Collection\CollectionInterface $leaveTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $leaveApplication->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $leaveApplication->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Leave Applications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leaveApplications form content">
            <?= $this->Form->create($leaveApplication) ?>
            <fieldset>
                <legend><?= __('Edit Leave Application') ?></legend>
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
