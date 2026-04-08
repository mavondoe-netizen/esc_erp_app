<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeasePayment $leasePayment
 * @var array $tenants, $units, $buildings, $accounts, $enrolments, $paymentModes, $currencies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leasePayments form content">
            <?= $this->Form->create($leasePayment) ?>
            <fieldset>
                <legend><?= __('Record Rental Payment') ?></legend>
                <div class="row">
                    <div class="column">
                        <?= $this->Form->control('tenant_id', ['options' => $tenants, 'empty' => '-- Select Tenant --']) ?>
                        <?= $this->Form->control('unit_id', ['options' => $units, 'empty' => '-- Select Unit --']) ?>
                        <?= $this->Form->control('building_id', ['options' => $buildings, 'empty' => '-- Select Building --']) ?>
                        <?= $this->Form->control('enrolment_id', ['options' => $enrolments, 'empty' => '-- Select Lease --', 'label' => 'Lease/Enrolment']) ?>
                    </div>
                    <div class="column">
                        <?= $this->Form->control('amount', ['type' => 'number', 'step' => '0.01']) ?>
                        <?= $this->Form->control('currency', ['type' => 'select', 'options' => $currencies]) ?>
                        <?= $this->Form->control('payment_mode', ['type' => 'select', 'options' => $paymentModes, 'empty' => '-- Select Mode --']) ?>
                        <?= $this->Form->control('account_id', ['options' => $accounts, 'empty' => '-- Cash/Bank Account --', 'label' => 'Deposited Into Account']) ?>
                    </div>
                </div>
                <?= $this->Form->control('date', ['label' => 'Payment Date']) ?>
                <?= $this->Form->control('period_covered', ['label' => 'Period Covered (e.g. April 2026)', 'placeholder' => date('F Y')]) ?>
                <?= $this->Form->control('reference', ['label' => 'Reference / Receipt No.', 'placeholder' => 'e.g. RCPT-001']) ?>
                <?= $this->Form->control('description', ['type' => 'textarea', 'rows' => 3]) ?>
            </fieldset>
            <?= $this->Form->button(__('Save Payment'), ['class' => 'button success']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
