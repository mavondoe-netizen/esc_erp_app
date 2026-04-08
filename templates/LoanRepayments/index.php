<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanRepayment> $loanRepayments
 */
?>
<div class="loanRepayments index content">
    <?= $this->Html->link(__('New Loan Repayment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Repayments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('loan_id') ?></th>
                    <th><?= $this->Paginator->sort('client_id') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('source') ?></th>
                    <th><?= $this->Paginator->sort('payment_date') ?></th>
                    <th><?= $this->Paginator->sort('penalty_paid') ?></th>
                    <th><?= $this->Paginator->sort('interest_paid') ?></th>
                    <th><?= $this->Paginator->sort('principal_paid') ?></th>
                    <th><?= $this->Paginator->sort('reference') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('processed_by') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanRepayments as $loanRepayment): ?>
                <tr>
                    <td><?= $this->Number->format($loanRepayment->id) ?></td>
                    <td><?= $loanRepayment->hasValue('loan') ? $this->Html->link($loanRepayment->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanRepayment->loan->id]) : '' ?></td>
                    <td><?= $loanRepayment->client_id === null ? '' : $this->Number->format($loanRepayment->client_id) ?></td>
                    <td><?= $this->Number->format($loanRepayment->amount) ?></td>
                    <td><?= h($loanRepayment->currency) ?></td>
                    <td><?= h($loanRepayment->source) ?></td>
                    <td><?= h($loanRepayment->payment_date) ?></td>
                    <td><?= $this->Number->format($loanRepayment->penalty_paid) ?></td>
                    <td><?= $this->Number->format($loanRepayment->interest_paid) ?></td>
                    <td><?= $this->Number->format($loanRepayment->principal_paid) ?></td>
                    <td><?= h($loanRepayment->reference) ?></td>
                    <td><?= $loanRepayment->hasValue('account') ? $this->Html->link($loanRepayment->account->name, ['controller' => 'Accounts', 'action' => 'view', $loanRepayment->account->id]) : '' ?></td>
                    <td><?= $loanRepayment->processed_by === null ? '' : $this->Number->format($loanRepayment->processed_by) ?></td>
                    <td><?= h($loanRepayment->created) ?></td>
                    <td><?= h($loanRepayment->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanRepayment->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanRepayment->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanRepayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanRepayment->id)]) ?>
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