<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanDisbursement> $loanDisbursements
 */
?>
<div class="loanDisbursements index content">
    <?= $this->Html->link(__('New Loan Disbursement'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Disbursements') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('loan_id') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('method') ?></th>
                    <th><?= $this->Paginator->sort('bank_reference') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('disbursed_by') ?></th>
                    <th><?= $this->Paginator->sort('disbursed_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanDisbursements as $loanDisbursement): ?>
                <tr>
                    <td><?= $this->Number->format($loanDisbursement->id) ?></td>
                    <td><?= $loanDisbursement->hasValue('loan') ? $this->Html->link($loanDisbursement->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanDisbursement->loan->id]) : '' ?></td>
                    <td><?= $this->Number->format($loanDisbursement->amount) ?></td>
                    <td><?= h($loanDisbursement->currency) ?></td>
                    <td><?= h($loanDisbursement->method) ?></td>
                    <td><?= h($loanDisbursement->bank_reference) ?></td>
                    <td><?= $loanDisbursement->hasValue('account') ? $this->Html->link($loanDisbursement->account->name, ['controller' => 'Accounts', 'action' => 'view', $loanDisbursement->account->id]) : '' ?></td>
                    <td><?= $loanDisbursement->disbursed_by === null ? '' : $this->Number->format($loanDisbursement->disbursed_by) ?></td>
                    <td><?= h($loanDisbursement->disbursed_at) ?></td>
                    <td><?= h($loanDisbursement->created) ?></td>
                    <td><?= h($loanDisbursement->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanDisbursement->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanDisbursement->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanDisbursement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanDisbursement->id)]) ?>
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