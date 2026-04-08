<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanClient $loanClient
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $employees
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Loan Clients'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanClients form content">
            <?= $this->Form->create($loanClient) ?>
            <fieldset>
                <legend><?= __('Add Loan Client') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('employee_id', ['options' => $employees, 'empty' => true]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('national_id');
                    echo $this->Form->control('dob', ['empty' => true]);
                    echo $this->Form->control('gender');
                    echo $this->Form->control('employer_name');
                    echo $this->Form->control('employment_type');
                    echo $this->Form->control('monthly_income');
                    echo $this->Form->control('income_currency');
                    echo $this->Form->control('contact_phone');
                    echo $this->Form->control('contact_email');
                    echo $this->Form->control('address');
                    echo $this->Form->control('status');
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
