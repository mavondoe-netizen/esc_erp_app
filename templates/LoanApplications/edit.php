<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanApplication $loanApplication
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $loanProducts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $loanApplication->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $loanApplication->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Loan Applications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanApplications form content">
            <?= $this->Form->create($loanApplication) ?>
            <fieldset>
                <legend><?= __('Edit Loan Application') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('client_id');
                    echo $this->Form->control('loan_product_id', ['options' => $loanProducts]);
                    echo $this->Form->control('amount_requested');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('term');
                    echo $this->Form->control('purpose');
                    echo $this->Form->control('status');
                    echo $this->Form->control('submitted_at', ['empty' => true]);
                    echo $this->Form->control('decided_at', ['empty' => true]);
                    echo $this->Form->control('decided_by');
                    echo $this->Form->control('rejection_reason');
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
