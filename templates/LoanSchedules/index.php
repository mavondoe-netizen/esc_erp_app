<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanSchedule> $loanSchedules
 */
?>
<div class="loanSchedules index content">
    <?= $this->Html->link(__('New Loan Schedule'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Schedules') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('loan_id') ?></th>
                    <th><?= $this->Paginator->sort('period_number') ?></th>
                    <th><?= $this->Paginator->sort('due_date') ?></th>
                    <th><?= $this->Paginator->sort('principal_due') ?></th>
                    <th><?= $this->Paginator->sort('interest_due') ?></th>
                    <th><?= $this->Paginator->sort('penalty_due') ?></th>
                    <th><?= $this->Paginator->sort('total_due') ?></th>
                    <th><?= $this->Paginator->sort('amount_paid') ?></th>
                    <th><?= $this->Paginator->sort('balance') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanSchedules as $loanSchedule): ?>
                <tr>
                    <td><?= $this->Number->format($loanSchedule->id) ?></td>
                    <td><?= $loanSchedule->hasValue('loan') ? $this->Html->link($loanSchedule->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanSchedule->loan->id]) : '' ?></td>
                    <td><?= $this->Number->format($loanSchedule->period_number) ?></td>
                    <td><?= h($loanSchedule->due_date) ?></td>
                    <td><?= $this->Number->format($loanSchedule->principal_due) ?></td>
                    <td><?= $this->Number->format($loanSchedule->interest_due) ?></td>
                    <td><?= $this->Number->format($loanSchedule->penalty_due) ?></td>
                    <td><?= $this->Number->format($loanSchedule->total_due) ?></td>
                    <td><?= $this->Number->format($loanSchedule->amount_paid) ?></td>
                    <td><?= $this->Number->format($loanSchedule->balance) ?></td>
                    <td><?= h($loanSchedule->currency) ?></td>
                    <td><?= h($loanSchedule->status) ?></td>
                    <td><?= h($loanSchedule->created) ?></td>
                    <td><?= h($loanSchedule->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanSchedule->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanSchedule->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanSchedule->id)]) ?>
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