<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanRestructure> $loanRestructures
 */
?>
<div class="loanRestructures index content">
    <?= $this->Html->link(__('New Loan Restructure'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Restructures') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('loan_id') ?></th>
                    <th><?= $this->Paginator->sort('old_term') ?></th>
                    <th><?= $this->Paginator->sort('new_term') ?></th>
                    <th><?= $this->Paginator->sort('old_rate') ?></th>
                    <th><?= $this->Paginator->sort('new_rate') ?></th>
                    <th><?= $this->Paginator->sort('outstanding_at_restructure') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('approved_by') ?></th>
                    <th><?= $this->Paginator->sort('approved_at') ?></th>
                    <th><?= $this->Paginator->sort('effective_date') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanRestructures as $loanRestructure): ?>
                <tr>
                    <td><?= $this->Number->format($loanRestructure->id) ?></td>
                    <td><?= $loanRestructure->hasValue('loan') ? $this->Html->link($loanRestructure->loan->interest_method, ['controller' => 'Loans', 'action' => 'view', $loanRestructure->loan->id]) : '' ?></td>
                    <td><?= $loanRestructure->old_term === null ? '' : $this->Number->format($loanRestructure->old_term) ?></td>
                    <td><?= $this->Number->format($loanRestructure->new_term) ?></td>
                    <td><?= $loanRestructure->old_rate === null ? '' : $this->Number->format($loanRestructure->old_rate) ?></td>
                    <td><?= $loanRestructure->new_rate === null ? '' : $this->Number->format($loanRestructure->new_rate) ?></td>
                    <td><?= $loanRestructure->outstanding_at_restructure === null ? '' : $this->Number->format($loanRestructure->outstanding_at_restructure) ?></td>
                    <td><?= h($loanRestructure->status) ?></td>
                    <td><?= $loanRestructure->approved_by === null ? '' : $this->Number->format($loanRestructure->approved_by) ?></td>
                    <td><?= h($loanRestructure->approved_at) ?></td>
                    <td><?= h($loanRestructure->effective_date) ?></td>
                    <td><?= h($loanRestructure->created) ?></td>
                    <td><?= h($loanRestructure->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanRestructure->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanRestructure->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanRestructure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanRestructure->id)]) ?>
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