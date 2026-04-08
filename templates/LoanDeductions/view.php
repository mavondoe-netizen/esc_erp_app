<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanDeduction $loanDeduction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Deduction'), ['action' => 'edit', $loanDeduction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Deduction'), ['action' => 'delete', $loanDeduction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanDeduction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Deductions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Deduction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanDeductions view content">
            <h3><?= h($loanDeduction->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Loan') ?></th>
                    <td><?= $loanDeduction->hasValue('loan') ? $this->Html->link($loanDeduction->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanDeduction->loan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $loanDeduction->hasValue('employee') ? $this->Html->link($loanDeduction->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $loanDeduction->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($loanDeduction->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($loanDeduction->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanDeduction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monthly Amount') ?></th>
                    <td><?= $this->Number->format($loanDeduction->monthly_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($loanDeduction->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanDeduction->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanDeduction->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanDeduction->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>