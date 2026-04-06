<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeProfile $employeeProfile
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Employee Profiles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="employeeProfiles form content">
            <?= $this->Form->create($employeeProfile) ?>
            <fieldset>
                <legend><?= __('Add Employee Profile') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('employee_id_number');
                    echo $this->Form->control('tax_number');
                    echo $this->Form->control('social_security_number');
                    echo $this->Form->control('hire_date', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
