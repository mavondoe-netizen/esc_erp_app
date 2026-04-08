<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanDeduction $loanDeduction
 * @var string[]|\Cake\Collection\CollectionInterface $loans
 * @var string[]|\Cake\Collection\CollectionInterface $employees
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $loanDeduction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $loanDeduction->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Loan Deductions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanDeductions form content">
            <?= $this->Form->create($loanDeduction) ?>
            <fieldset>
                <legend><?= __('Edit Loan Deduction') ?></legend>
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
