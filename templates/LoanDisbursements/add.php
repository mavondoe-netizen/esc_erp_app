<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanDisbursement $loanDisbursement
 * @var \Cake\Collection\CollectionInterface|string[] $loans
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Loan Disbursements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanDisbursements form content">
            <?= $this->Form->create($loanDisbursement) ?>
            <fieldset>
                <legend><?= __('Add Loan Disbursement') ?></legend>
                <?php
                    echo $this->Form->control('loan_id', ['options' => $loans]);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('method');
                    echo $this->Form->control('bank_reference');
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
                    echo $this->Form->control('disbursed_by');
                    echo $this->Form->control('disbursed_at', ['empty' => true]);
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
