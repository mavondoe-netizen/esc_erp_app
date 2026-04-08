<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeasePayment $leasePayment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Lease Payment'), ['action' => 'edit', $leasePayment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Lease Payment'), ['action' => 'delete', $leasePayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leasePayment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Lease Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Lease Payment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leasePayments view content">
            <h3><?= h($leasePayment->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $leasePayment->hasValue('company') ? $this->Html->link($leasePayment->company->name, ['controller' => 'Companies', 'action' => 'view', $leasePayment->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Enrolment') ?></th>
                    <td><?= $leasePayment->hasValue('enrolment') ? $this->Html->link($leasePayment->enrolment->id, ['controller' => 'Enrolments', 'action' => 'view', $leasePayment->enrolment->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tenant') ?></th>
                    <td><?= $leasePayment->hasValue('tenant') ? $this->Html->link($leasePayment->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $leasePayment->tenant->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= $leasePayment->hasValue('unit') ? $this->Html->link($leasePayment->unit->name, ['controller' => 'Units', 'action' => 'view', $leasePayment->unit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Building') ?></th>
                    <td><?= $leasePayment->hasValue('building') ? $this->Html->link($leasePayment->building->name, ['controller' => 'Buildings', 'action' => 'view', $leasePayment->building->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $leasePayment->hasValue('account') ? $this->Html->link($leasePayment->account->name, ['controller' => 'Accounts', 'action' => 'view', $leasePayment->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($leasePayment->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Mode') ?></th>
                    <td><?= h($leasePayment->payment_mode) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reference') ?></th>
                    <td><?= h($leasePayment->reference) ?></td>
                </tr>
                <tr>
                    <th><?= __('Period Covered') ?></th>
                    <td><?= h($leasePayment->period_covered) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($leasePayment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($leasePayment->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($leasePayment->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($leasePayment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($leasePayment->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($leasePayment->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>