<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ZimraReconciliation $zimraReconciliation
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 * @var \Cake\Collection\CollectionInterface|string[] $employees
 * @var \Cake\Collection\CollectionInterface|string[] $payPeriods
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Zimra Reconciliations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="zimraReconciliations form content">
            <?= $this->Form->create($zimraReconciliation) ?>
            <fieldset>
                <legend><?= __('Add Zimra Reconciliation') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('employee_id', ['options' => $employees]);
                    echo $this->Form->control('pay_period_id', ['options' => $payPeriods]);
                    echo $this->Form->control('payroll_tax_amount');
                    echo $this->Form->control('assessed_tax_amount');
                    echo $this->Form->control('variance');
                    echo $this->Form->control('status');
                    echo $this->Form->control('cleared_date', ['empty' => true]);
                    echo $this->Form->control('cleared_via');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
