<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ZimraReconciliation> $zimraReconciliations
 */
?>
<div class="zimraReconciliations index content">
    <?= $this->Html->link(__('New Zimra Reconciliation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Zimra Reconciliations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id') ?></th>
                    <th><?= $this->Paginator->sort('pay_period_id') ?></th>
                    <th><?= $this->Paginator->sort('payroll_tax_amount') ?></th>
                    <th><?= $this->Paginator->sort('assessed_tax_amount') ?></th>
                    <th><?= $this->Paginator->sort('variance') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('cleared_date') ?></th>
                    <th><?= $this->Paginator->sort('cleared_via') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($zimraReconciliations as $zimraReconciliation): ?>
                <tr>
                    <td><?= $this->Number->format($zimraReconciliation->id) ?></td>
                    <td><?= $zimraReconciliation->hasValue('company') ? $this->Html->link($zimraReconciliation->company->name, ['controller' => 'Companies', 'action' => 'view', $zimraReconciliation->company->id]) : '' ?></td>
                    <td><?= $zimraReconciliation->hasValue('employee') ? $this->Html->link($zimraReconciliation->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $zimraReconciliation->employee->id]) : '' ?></td>
                    <td><?= $zimraReconciliation->hasValue('pay_period') ? $this->Html->link($zimraReconciliation->pay_period->id, ['controller' => 'PayPeriods', 'action' => 'view', $zimraReconciliation->pay_period->id]) : '' ?></td>
                    <td><?= $this->Number->format($zimraReconciliation->payroll_tax_amount) ?></td>
                    <td><?= $this->Number->format($zimraReconciliation->assessed_tax_amount) ?></td>
                    <td><?= $this->Number->format($zimraReconciliation->variance) ?></td>
                    <td><?= h($zimraReconciliation->status) ?></td>
                    <td><?= h($zimraReconciliation->cleared_date) ?></td>
                    <td><?= h($zimraReconciliation->cleared_via) ?></td>
                    <td><?= h($zimraReconciliation->created) ?></td>
                    <td><?= h($zimraReconciliation->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $zimraReconciliation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $zimraReconciliation->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $zimraReconciliation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $zimraReconciliation->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>