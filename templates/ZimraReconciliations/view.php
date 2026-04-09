<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ZimraReconciliation $zimraReconciliation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Zimra Reconciliation'), ['action' => 'edit', $zimraReconciliation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Zimra Reconciliation'), ['action' => 'delete', $zimraReconciliation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $zimraReconciliation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Zimra Reconciliations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Zimra Reconciliation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="zimraReconciliations view content">
            <h3><?= h($zimraReconciliation->status) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $zimraReconciliation->hasValue('company') ? $this->Html->link($zimraReconciliation->company->name, ['controller' => 'Companies', 'action' => 'view', $zimraReconciliation->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $zimraReconciliation->hasValue('employee') ? $this->Html->link($zimraReconciliation->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $zimraReconciliation->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Pay Period') ?></th>
                    <td><?= $zimraReconciliation->hasValue('pay_period') ? $this->Html->link($zimraReconciliation->pay_period->id, ['controller' => 'PayPeriods', 'action' => 'view', $zimraReconciliation->pay_period->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($zimraReconciliation->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cleared Via') ?></th>
                    <td><?= h($zimraReconciliation->cleared_via) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($zimraReconciliation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payroll Tax Amount') ?></th>
                    <td><?= $this->Number->format($zimraReconciliation->payroll_tax_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Assessed Tax Amount') ?></th>
                    <td><?= $this->Number->format($zimraReconciliation->assessed_tax_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Variance') ?></th>
                    <td><?= $this->Number->format($zimraReconciliation->variance) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cleared Date') ?></th>
                    <td><?= h($zimraReconciliation->cleared_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($zimraReconciliation->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($zimraReconciliation->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>