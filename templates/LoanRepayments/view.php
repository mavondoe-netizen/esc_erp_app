<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LoanRepayment $loanRepayment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Loan Repayment'), ['action' => 'edit', $loanRepayment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Loan Repayment'), ['action' => 'delete', $loanRepayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanRepayment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Loan Repayments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Loan Repayment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="loanRepayments view content">
            <h3><?= h($loanRepayment->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('Loan') ?></th>
                    <td><?= $loanRepayment->hasValue('loan') ? $this->Html->link($loanRepayment->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanRepayment->loan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($loanRepayment->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Source') ?></th>
                    <td><?= h($loanRepayment->source) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reference') ?></th>
                    <td><?= h($loanRepayment->reference) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= $loanRepayment->hasValue('account') ? $this->Html->link($loanRepayment->account->name, ['controller' => 'Accounts', 'action' => 'view', $loanRepayment->account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($loanRepayment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Client Id') ?></th>
                    <td><?= $loanRepayment->client_id === null ? '' : $this->Number->format($loanRepayment->client_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($loanRepayment->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Penalty Paid') ?></th>
                    <td><?= $this->Number->format($loanRepayment->penalty_paid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Interest Paid') ?></th>
                    <td><?= $this->Number->format($loanRepayment->interest_paid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Principal Paid') ?></th>
                    <td><?= $this->Number->format($loanRepayment->principal_paid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Processed By') ?></th>
                    <td><?= $loanRepayment->processed_by === null ? '' : $this->Number->format($loanRepayment->processed_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Date') ?></th>
                    <td><?= h($loanRepayment->payment_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($loanRepayment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($loanRepayment->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Allocation Json') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanRepayment->allocation_json)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($loanRepayment->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>