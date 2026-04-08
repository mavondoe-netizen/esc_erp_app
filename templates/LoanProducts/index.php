<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanProduct> $loanProducts
 */
?>
<div class="loanProducts index content">
    <?= $this->Html->link(__('New Loan Product'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Products') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('interest_rate') ?></th>
                    <th><?= $this->Paginator->sort('interest_method') ?></th>
                    <th><?= $this->Paginator->sort('repayment_frequency') ?></th>
                    <th><?= $this->Paginator->sort('min_amount') ?></th>
                    <th><?= $this->Paginator->sort('max_amount') ?></th>
                    <th><?= $this->Paginator->sort('max_term') ?></th>
                    <th><?= $this->Paginator->sort('min_term') ?></th>
                    <th><?= $this->Paginator->sort('grace_period_days') ?></th>
                    <th><?= $this->Paginator->sort('penalty_rate') ?></th>
                    <th><?= $this->Paginator->sort('requires_guarantor') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanProducts as $loanProduct): ?>
                <tr>
                    <td><?= $this->Number->format($loanProduct->id) ?></td>
                    <td><?= $loanProduct->hasValue('company') ? $this->Html->link($loanProduct->company->name, ['controller' => 'Companies', 'action' => 'view', $loanProduct->company->id]) : '' ?></td>
                    <td><?= h($loanProduct->name) ?></td>
                    <td><?= h($loanProduct->code) ?></td>
                    <td><?= $this->Number->format($loanProduct->interest_rate) ?></td>
                    <td><?= h($loanProduct->interest_method) ?></td>
                    <td><?= h($loanProduct->repayment_frequency) ?></td>
                    <td><?= $this->Number->format($loanProduct->min_amount) ?></td>
                    <td><?= $this->Number->format($loanProduct->max_amount) ?></td>
                    <td><?= $this->Number->format($loanProduct->max_term) ?></td>
                    <td><?= $this->Number->format($loanProduct->min_term) ?></td>
                    <td><?= $this->Number->format($loanProduct->grace_period_days) ?></td>
                    <td><?= $this->Number->format($loanProduct->penalty_rate) ?></td>
                    <td><?= h($loanProduct->requires_guarantor) ?></td>
                    <td><?= h($loanProduct->currency) ?></td>
                    <td><?= h($loanProduct->is_active) ?></td>
                    <td><?= h($loanProduct->created) ?></td>
                    <td><?= h($loanProduct->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanProduct->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanProduct->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanProduct->id)]) ?>
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