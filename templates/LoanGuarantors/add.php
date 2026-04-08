<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanGuarantor $loanGuarantor
 * @var \Cake\Collection\CollectionInterface|string[] $loanApplications
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Loan Guarantors'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanGuarantors form content">
            <?= $this->Form->create($loanGuarantor) ?>
            <fieldset>
                <legend><?= __('Add Loan Guarantor') ?></legend>
                <?php
                    echo $this->Form->control('loan_application_id', ['options' => $loanApplications]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('national_id');
                    echo $this->Form->control('relationship');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('employer');
                    echo $this->Form->control('monthly_income');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
