<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Loan $loan
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $loanApplications
 * @var string[]|\Cake\Collection\CollectionInterface $loanProducts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $loan->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $loan->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Loans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loans form content">
            <?= $this->Form->create($loan) ?>
            <fieldset>
                <legend><?= __('Edit Loan') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('client_id');
                    echo $this->Form->control('loan_application_id', ['options' => $loanApplications, 'empty' => true]);
                    echo $this->Form->control('loan_product_id', ['options' => $loanProducts, 'empty' => true]);
                    echo $this->Form->control('loan_account_no');
                    echo $this->Form->control('principal');
                    echo $this->Form->control('outstanding_balance');
                    echo $this->Form->control('interest_rate');
                    echo $this->Form->control('interest_method');
                    echo $this->Form->control('repayment_frequency');
                    echo $this->Form->control('term');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('start_date', ['empty' => true]);
                    echo $this->Form->control('maturity_date', ['empty' => true]);
                    echo $this->Form->control('disbursed_at', ['empty' => true]);
                    echo $this->Form->control('last_payment_date', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
