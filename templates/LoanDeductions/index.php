<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanDeduction> $loanDeductions
 */
?>
<div class="loanDeductions index content">
    <?= $this->Html->link(__('New Loan Deduction'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Deductions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('loan_id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id') ?></th>
                    <th><?= $this->Paginator->sort('monthly_amount') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanDeductions as $loanDeduction): ?>
                <tr>
                    <td><?= $this->Number->format($loanDeduction->id) ?></td>
                    <td><?= $loanDeduction->hasValue('loan') ? $this->Html->link($loanDeduction->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanDeduction->loan->id]) : '' ?></td>
                    <td><?= $loanDeduction->hasValue('employee') ? $this->Html->link($loanDeduction->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $loanDeduction->employee->id]) : '' ?></td>
                    <td><?= $this->Number->format($loanDeduction->monthly_amount) ?></td>
                    <td><?= h($loanDeduction->currency) ?></td>
                    <td><?= h($loanDeduction->status) ?></td>
                    <td><?= h($loanDeduction->start_date) ?></td>
                    <td><?= h($loanDeduction->created) ?></td>
                    <td><?= h($loanDeduction->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanDeduction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanDeduction->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanDeduction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanDeduction->id)]) ?>
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