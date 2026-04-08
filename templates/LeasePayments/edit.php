<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeasePayment $leasePayment
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $enrolments
 * @var string[]|\Cake\Collection\CollectionInterface $tenants
 * @var string[]|\Cake\Collection\CollectionInterface $units
 * @var string[]|\Cake\Collection\CollectionInterface $buildings
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $leasePayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $leasePayment->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Lease Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leasePayments form content">
            <?= $this->Form->create($leasePayment) ?>
            <fieldset>
                <legend><?= __('Edit Lease Payment') ?></legend>
                <?php
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                    echo $this->Form->control('enrolment_id', ['options' => $enrolments, 'empty' => true]);
                    echo $this->Form->control('tenant_id', ['options' => $tenants, 'empty' => true]);
                    echo $this->Form->control('unit_id', ['options' => $units, 'empty' => true]);
                    echo $this->Form->control('building_id', ['options' => $buildings, 'empty' => true]);
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('currency');
                    echo $this->Form->control('payment_mode');
                    echo $this->Form->control('reference');
                    echo $this->Form->control('period_covered');
                    echo $this->Form->control('date');
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
