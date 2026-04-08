<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LeasePayment> $leasePayments
 */
?>
<div class="leasePayments index content">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h3><?= __('Rental Payments') ?></h3>
        <?= $this->Html->link(__('+ Record Payment'), ['action' => 'add'], ['class' => 'button success']) ?>
    </div>
    <div class="table-responsive">
        <table id="leasePaymentsTable">
            <thead>
                <tr>
                    <th><?= __('Date') ?></th>
                    <th><?= __('Tenant') ?></th>
                    <th><?= __('Unit') ?></th>
                    <th><?= __('Building') ?></th>
                    <th><?= __('Period') ?></th>
                    <th><?= __('Amount') ?></th>
                    <th><?= __('Mode') ?></th>
                    <th><?= __('Reference') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leasePayments as $p): ?>
                <tr>
                    <td><?= h($p->date) ?></td>
                    <td><?= $p->hasValue('tenant') ? h($p->tenant->name) : '–' ?></td>
                    <td><?= $p->hasValue('unit') ? h($p->unit->name) : '–' ?></td>
                    <td><?= $p->hasValue('building') ? h($p->building->name) : '–' ?></td>
                    <td><?= h($p->period_covered) ?></td>
                    <td><strong><?= h($p->currency) ?> <?= number_format((float)$p->amount, 2) ?></strong></td>
                    <td><?= h($p->payment_mode) ?></td>
                    <td><?= h($p->reference) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $p->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $p->id], ['confirm' => 'Delete this payment?']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>