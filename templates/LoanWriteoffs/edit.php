<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanWriteoff $loanWriteoff
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
                ['action' => 'delete', $loanWriteoff->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $loanWriteoff->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Loan Writeoffs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanWriteoffs form content">
            <?= $this->Form->create($loanWriteoff) ?>
            <fieldset>
                <legend><?= __('Edit Loan Writeoff') ?></legend>
                <?php
                    echo $this->Form->control('loan_id', ['options' => $loans]);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('outstanding_at_writeoff');
                    echo $this->Form->control('reason');
                    echo $this->Form->control('status');
                    echo $this->Form->control('approved_by');
                    echo $this->Form->control('approved_at', ['empty' => true]);
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
