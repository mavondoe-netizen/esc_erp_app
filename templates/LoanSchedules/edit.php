<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanSchedule $loanSchedule
 * @var string[]|\Cake\Collection\CollectionInterface $loans
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $loanSchedule->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $loanSchedule->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Loan Schedules'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanSchedules form content">
            <?= $this->Form->create($loanSchedule) ?>
            <fieldset>
                <legend><?= __('Edit Loan Schedule') ?></legend>
                <?php
                    echo $this->Form->control('loan_id', ['options' => $loans]);
                    echo $this->Form->control('period_number');
                    echo $this->Form->control('due_date');
                    echo $this->Form->control('principal_due');
                    echo $this->Form->control('interest_due');
                    echo $this->Form->control('penalty_due');
                    echo $this->Form->control('total_due');
                    echo $this->Form->control('amount_paid');
                    echo $this->Form->control('balance');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
