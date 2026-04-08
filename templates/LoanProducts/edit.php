<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanProduct $loanProduct
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $loanProduct->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $loanProduct->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Loan Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanProducts form content">
            <?= $this->Form->create($loanProduct) ?>
            <fieldset>
                <legend><?= __('Edit Loan Product') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('code');
                    echo $this->Form->control('interest_rate');
                    echo $this->Form->control('interest_method');
                    echo $this->Form->control('repayment_frequency');
                    echo $this->Form->control('min_amount');
                    echo $this->Form->control('max_amount');
                    echo $this->Form->control('max_term');
                    echo $this->Form->control('min_term');
                    echo $this->Form->control('grace_period_days');
                    echo $this->Form->control('penalty_rate');
                    echo $this->Form->control('requires_guarantor');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
