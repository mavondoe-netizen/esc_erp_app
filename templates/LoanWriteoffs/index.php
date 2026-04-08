<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanWriteoff> $loanWriteoffs
 */
?>
<div class="loanWriteoffs index content">
    <?= $this->Html->link(__('New Loan Writeoff'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Writeoffs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('loan_id') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('outstanding_at_writeoff') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('approved_by') ?></th>
                    <th><?= $this->Paginator->sort('approved_at') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanWriteoffs as $loanWriteoff): ?>
                <tr>
                    <td><?= $this->Number->format($loanWriteoff->id) ?></td>
                    <td><?= $loanWriteoff->hasValue('loan') ? $this->Html->link($loanWriteoff->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanWriteoff->loan->id]) : '' ?></td>
                    <td><?= $this->Number->format($loanWriteoff->amount) ?></td>
                    <td><?= h($loanWriteoff->currency) ?></td>
                    <td><?= $loanWriteoff->outstanding_at_writeoff === null ? '' : $this->Number->format($loanWriteoff->outstanding_at_writeoff) ?></td>
                    <td><?= h($loanWriteoff->status) ?></td>
                    <td><?= $loanWriteoff->approved_by === null ? '' : $this->Number->format($loanWriteoff->approved_by) ?></td>
                    <td><?= h($loanWriteoff->approved_at) ?></td>
                    <td><?= $loanWriteoff->hasValue('account') ? $this->Html->link($loanWriteoff->account->name, ['controller' => 'Accounts', 'action' => 'view', $loanWriteoff->account->id]) : '' ?></td>
                    <td><?= h($loanWriteoff->created) ?></td>
                    <td><?= h($loanWriteoff->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanWriteoff->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanWriteoff->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanWriteoff->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanWriteoff->id)]) ?>
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