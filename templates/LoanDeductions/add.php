<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanDeduction $loanDeduction
 * @var \Cake\Collection\CollectionInterface|string[] $loans
 * @var \Cake\Collection\CollectionInterface|string[] $employees
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Loan Deductions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanDeductions form content">
            <?= $this->Form->create($loanDeduction) ?>
            <fieldset>
                <legend><?= __('Add Loan Deduction') ?></legend>
                <?php
                    echo $this->Form->control('loan_id', ['options' => $loans]);
                    echo $this->Form->control('employee_id', ['options' => $employees]);
                    echo $this->Form->control('monthly_amount');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('status');
                    echo $this->Form->control('start_date', ['empty' => true]);
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
