<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanRestructure $loanRestructure
 * @var string[]|\Cake\Collection\CollectionInterface $loans
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $loanRestructure->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $loanRestructure->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Loan Restructures'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanRestructures form content">
            <?= $this->Form->create($loanRestructure) ?>
            <fieldset>
                <legend><?= __('Edit Loan Restructure') ?></legend>
                <?php
                    echo $this->Form->control('loan_id', ['options' => $loans]);
                    echo $this->Form->control('old_term');
                    echo $this->Form->control('new_term');
                    echo $this->Form->control('old_rate');
                    echo $this->Form->control('new_rate');
                    echo $this->Form->control('outstanding_at_restructure');
                    echo $this->Form->control('reason');
                    echo $this->Form->control('status');
                    echo $this->Form->control('approved_by');
                    echo $this->Form->control('approved_at', ['empty' => true]);
                    echo $this->Form->control('effective_date', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
