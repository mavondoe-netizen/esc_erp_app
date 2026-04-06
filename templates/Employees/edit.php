<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $employee->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Employees'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="employees form content">
            <?= $this->Form->create($employee) ?>
            <fieldset>
                <legend><?= __('Edit Employee') ?></legend>
                <?php
                    echo $this->Form->control('employee_code');
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('nssa_number');
                    echo $this->Form->control('tax_number');
                    echo $this->Form->control('date_of_birth');
                    echo $this->Form->control('disabled');
                    echo $this->Form->control('designation');
                    echo $this->Form->control('basic_salary');
                    echo $this->Form->control('national_identity');
                    echo $this->Form->control('is_blind');
                    echo $this->Form->control('usd_bank');
                    echo $this->Form->control('usd_branch');
                    echo $this->Form->control('usd_account');
                    echo $this->Form->control('zwg_bank');
                    echo $this->Form->control('zwg_branch');
                    echo $this->Form->control('zwg_account');
                    echo $this->Form->control('start_date', ['empty' => true]);
                    echo $this->Form->control('termination_date', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
