<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanRepayment $loanRepayment
 * @var string[]|\Cake\Collection\CollectionInterface $loans
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $loanRepayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $loanRepayment->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Loan Repayments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanRepayments form content">
            <?= $this->Form->create($loanRepayment) ?>
            <fieldset>
                <legend><?= __('Edit Loan Repayment') ?></legend>
                <?php
                    echo $this->Form->control('loan_id', ['options' => $loans]);
                    echo $this->Form->control('client_id');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('source');
                    echo $this->Form->control('payment_date');
                    echo $this->Form->control('penalty_paid');
                    echo $this->Form->control('interest_paid');
                    echo $this->Form->control('principal_paid');
                    echo $this->Form->control('reference');
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
                    echo $this->Form->control('processed_by');
                    echo $this->Form->control('allocation_json');
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
