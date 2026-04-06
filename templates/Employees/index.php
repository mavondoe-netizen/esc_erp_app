<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Employee> $employees
 */
?>
<div class="employees index content">
    <?= $this->Html->link(__('New Employee'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Employees') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('employee_code') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('nssa_number') ?></th>
                    <th><?= $this->Paginator->sort('tax_number') ?></th>
                    <th><?= $this->Paginator->sort('date_of_birth') ?></th>
                    <th><?= $this->Paginator->sort('disabled') ?></th>
                    <th><?= $this->Paginator->sort('designation') ?></th>
                    <th><?= $this->Paginator->sort('basic_salary') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('national_identity') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('is_blind') ?></th>
                    <th><?= $this->Paginator->sort('usd_bank') ?></th>
                    <th><?= $this->Paginator->sort('usd_branch') ?></th>
                    <th><?= $this->Paginator->sort('usd_account') ?></th>
                    <th><?= $this->Paginator->sort('zwg_bank') ?></th>
                    <th><?= $this->Paginator->sort('zwg_branch') ?></th>
                    <th><?= $this->Paginator->sort('zwg_account') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('termination_date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= $this->Number->format($employee->id) ?></td>
                    <td><?= h($employee->employee_code) ?></td>
                    <td><?= h($employee->first_name) ?></td>
                    <td><?= h($employee->last_name) ?></td>
                    <td><?= $this->Number->format($employee->nssa_number) ?></td>
                    <td><?= $this->Number->format($employee->tax_number) ?></td>
                    <td><?= h($employee->date_of_birth) ?></td>
                    <td><?= h($employee->disabled) ?></td>
                    <td><?= h($employee->designation) ?></td>
                    <td><?= $this->Number->format($employee->basic_salary) ?></td>
                    <td><?= h($employee->created) ?></td>
                    <td><?= h($employee->modified) ?></td>
                    <td><?= h($employee->national_identity) ?></td>
                    <td><?= $employee->hasValue('company') ? $this->Html->link($employee->company->name, ['controller' => 'Companies', 'action' => 'view', $employee->company->id]) : '' ?></td>
                    <td><?= h($employee->is_blind) ?></td>
                    <td><?= h($employee->usd_bank) ?></td>
                    <td><?= h($employee->usd_branch) ?></td>
                    <td><?= h($employee->usd_account) ?></td>
                    <td><?= h($employee->zwg_bank) ?></td>
                    <td><?= h($employee->zwg_branch) ?></td>
                    <td><?= h($employee->zwg_account) ?></td>
                    <td><?= h($employee->start_date) ?></td>
                    <td><?= h($employee->termination_date) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $employee->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employee->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]) ?>
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