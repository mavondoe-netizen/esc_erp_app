<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Loan> $loans
 */
?>
<div class="loans index content">
    <?= $this->Html->link(__('New Loan'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loans') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('client_id') ?></th>
                    <th><?= $this->Paginator->sort('loan_application_id') ?></th>
                    <th><?= $this->Paginator->sort('loan_product_id') ?></th>
                    <th><?= $this->Paginator->sort('loan_account_no') ?></th>
                    <th><?= $this->Paginator->sort('principal') ?></th>
                    <th><?= $this->Paginator->sort('outstanding_balance') ?></th>
                    <th><?= $this->Paginator->sort('interest_rate') ?></th>
                    <th><?= $this->Paginator->sort('interest_method') ?></th>
                    <th><?= $this->Paginator->sort('repayment_frequency') ?></th>
                    <th><?= $this->Paginator->sort('term') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('maturity_date') ?></th>
                    <th><?= $this->Paginator->sort('disbursed_at') ?></th>
                    <th><?= $this->Paginator->sort('last_payment_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?>
                <tr>
                    <td><?= $this->Number->format($loan->id) ?></td>
                    <td><?= $loan->hasValue('company') ? $this->Html->link($loan->company->name, ['controller' => 'Companies', 'action' => 'view', $loan->company->id]) : '' ?></td>
                    <td><?= $this->Number->format($loan->client_id) ?></td>
                    <td><?= $loan->hasValue('loan_application') ? $this->Html->link($loan->loan_application->currency, ['controller' => 'LoanApplications', 'action' => 'view', $loan->loan_application->id]) : '' ?></td>
                    <td><?= $loan->hasValue('loan_product') ? $this->Html->link($loan->loan_product->name, ['controller' => 'LoanProducts', 'action' => 'view', $loan->loan_product->id]) : '' ?></td>
                    <td><?= h($loan->loan_account_no) ?></td>
                    <td><?= $this->Number->format($loan->principal) ?></td>
                    <td><?= $this->Number->format($loan->outstanding_balance) ?></td>
                    <td><?= $this->Number->format($loan->interest_rate) ?></td>
                    <td><?= h($loan->interest_method) ?></td>
                    <td><?= h($loan->repayment_frequency) ?></td>
                    <td><?= $this->Number->format($loan->term) ?></td>
                    <td><?= h($loan->currency) ?></td>
                    <td><?= h($loan->start_date) ?></td>
                    <td><?= h($loan->maturity_date) ?></td>
                    <td><?= h($loan->disbursed_at) ?></td>
                    <td><?= h($loan->last_payment_date) ?></td>
                    <td><?= h($loan->status) ?></td>
                    <td><?= h($loan->created) ?></td>
                    <td><?= h($loan->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loan->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loan->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loan->id)]) ?>
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