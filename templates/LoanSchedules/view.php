<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanSchedule $loanSchedule
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Schedule'), ['action' => 'edit', $loanSchedule->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Schedule'), ['action' => 'delete', $loanSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanSchedule->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Schedules'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Schedule'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanSchedules view content">
            <h3><?= h($loanSchedule->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Loan') ?></th>
                    <td><?= $loanSchedule->hasValue('loan') ? $this->Html->link($loanSchedule->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanSchedule->loan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($loanSchedule->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($loanSchedule->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanSchedule->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Period Number') ?></th>
                    <td><?= $this->Number->format($loanSchedule->period_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Principal Due') ?></th>
                    <td><?= $this->Number->format($loanSchedule->principal_due) ?></td>
                </tr>
                <tr>
                    <th><?= __('Interest Due') ?></th>
                    <td><?= $this->Number->format($loanSchedule->interest_due) ?></td>
                </tr>
                <tr>
                    <th><?= __('Penalty Due') ?></th>
                    <td><?= $this->Number->format($loanSchedule->penalty_due) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Due') ?></th>
                    <td><?= $this->Number->format($loanSchedule->total_due) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount Paid') ?></th>
                    <td><?= $this->Number->format($loanSchedule->amount_paid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Balance') ?></th>
                    <td><?= $this->Number->format($loanSchedule->balance) ?></td>
                </tr>
                <tr>
                    <th><?= __('Due Date') ?></th>
                    <td><?= h($loanSchedule->due_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanSchedule->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanSchedule->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>