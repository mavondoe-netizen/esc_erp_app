<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveBalance $leaveBalance
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
                ['action' => 'delete', $leaveBalance->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $leaveBalance->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Leave Balances'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leaveBalances form content">
            <?= $this->Form->create($leaveBalance) ?>
            <fieldset>
                <legend><?= __('Edit Leave Balance') ?></legend>
                <?php
                    echo $this->Form->control('employee_id', ['options' => $employees]);
                    echo $this->Form->control('leave_type_id', ['options' => $leaveTypes]);
                    echo $this->Form->control('year');
                    echo $this->Form->control('days_entitled');
                    echo $this->Form->control('days_taken');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
