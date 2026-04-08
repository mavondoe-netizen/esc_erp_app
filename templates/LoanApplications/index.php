<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanApplication> $loanApplications
 */
?>
<div class="loanApplications index content">
    <?= $this->Html->link(__('New Loan Application'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Applications') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('client_id') ?></th>
                    <th><?= $this->Paginator->sort('loan_product_id') ?></th>
                    <th><?= $this->Paginator->sort('amount_requested') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('term') ?></th>
                    <th><?= $this->Paginator->sort('purpose') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('submitted_at') ?></th>
                    <th><?= $this->Paginator->sort('decided_at') ?></th>
                    <th><?= $this->Paginator->sort('decided_by') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanApplications as $loanApplication): ?>
                <tr>
                    <td><?= $this->Number->format($loanApplication->id) ?></td>
                    <td><?= $loanApplication->hasValue('company') ? $this->Html->link($loanApplication->company->name, ['controller' => 'Companies', 'action' => 'view', $loanApplication->company->id]) : '' ?></td>
                    <td><?= $this->Number->format($loanApplication->client_id) ?></td>
                    <td><?= $loanApplication->hasValue('loan_product') ? $this->Html->link($loanApplication->loan_product->name, ['controller' => 'LoanProducts', 'action' => 'view', $loanApplication->loan_product->id]) : '' ?></td>
                    <td><?= $this->Number->format($loanApplication->amount_requested) ?></td>
                    <td><?= h($loanApplication->currency) ?></td>
                    <td><?= $this->Number->format($loanApplication->term) ?></td>
                    <td><?= h($loanApplication->purpose) ?></td>
                    <td><?= h($loanApplication->status) ?></td>
                    <td><?= h($loanApplication->submitted_at) ?></td>
                    <td><?= h($loanApplication->decided_at) ?></td>
                    <td><?= $loanApplication->decided_by === null ? '' : $this->Number->format($loanApplication->decided_by) ?></td>
                    <td><?= h($loanApplication->created) ?></td>
                    <td><?= h($loanApplication->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanApplication->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanApplication->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanApplication->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanApplication->id)]) ?>
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