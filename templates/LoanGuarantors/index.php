<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanGuarantor> $loanGuarantors
 */
?>
<div class="loanGuarantors index content">
    <?= $this->Html->link(__('New Loan Guarantor'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Guarantors') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('loan_application_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('national_id') ?></th>
                    <th><?= $this->Paginator->sort('relationship') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('employer') ?></th>
                    <th><?= $this->Paginator->sort('monthly_income') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanGuarantors as $loanGuarantor): ?>
                <tr>
                    <td><?= $this->Number->format($loanGuarantor->id) ?></td>
                    <td><?= $loanGuarantor->hasValue('loan_application') ? $this->Html->link($loanGuarantor->loan_application->currency, ['controller' => 'LoanApplications', 'action' => 'view', $loanGuarantor->loan_application->id]) : '' ?></td>
                    <td><?= h($loanGuarantor->name) ?></td>
                    <td><?= h($loanGuarantor->national_id) ?></td>
                    <td><?= h($loanGuarantor->relationship) ?></td>
                    <td><?= h($loanGuarantor->phone) ?></td>
                    <td><?= h($loanGuarantor->employer) ?></td>
                    <td><?= $loanGuarantor->monthly_income === null ? '' : $this->Number->format($loanGuarantor->monthly_income) ?></td>
                    <td><?= h($loanGuarantor->currency) ?></td>
                    <td><?= h($loanGuarantor->status) ?></td>
                    <td><?= h($loanGuarantor->created) ?></td>
                    <td><?= h($loanGuarantor->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanGuarantor->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanGuarantor->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanGuarantor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanGuarantor->id)]) ?>
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