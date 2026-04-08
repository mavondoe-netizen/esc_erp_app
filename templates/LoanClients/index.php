<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LoanClient> $loanClients
 */
?>
<div class="loanClients index content">
    <?= $this->Html->link(__('New Loan Client'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Loan Clients') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('company_id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('national_id') ?></th>
                    <th><?= $this->Paginator->sort('dob') ?></th>
                    <th><?= $this->Paginator->sort('gender') ?></th>
                    <th><?= $this->Paginator->sort('employer_name') ?></th>
                    <th><?= $this->Paginator->sort('employment_type') ?></th>
                    <th><?= $this->Paginator->sort('monthly_income') ?></th>
                    <th><?= $this->Paginator->sort('income_currency') ?></th>
                    <th><?= $this->Paginator->sort('contact_phone') ?></th>
                    <th><?= $this->Paginator->sort('contact_email') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loanClients as $loanClient): ?>
                <tr>
                    <td><?= $this->Number->format($loanClient->id) ?></td>
                    <td><?= $loanClient->hasValue('company') ? $this->Html->link($loanClient->company->name, ['controller' => 'Companies', 'action' => 'view', $loanClient->company->id]) : '' ?></td>
                    <td><?= $loanClient->hasValue('employee') ? $this->Html->link($loanClient->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $loanClient->employee->id]) : '' ?></td>
                    <td><?= h($loanClient->name) ?></td>
                    <td><?= h($loanClient->national_id) ?></td>
                    <td><?= h($loanClient->dob) ?></td>
                    <td><?= h($loanClient->gender) ?></td>
                    <td><?= h($loanClient->employer_name) ?></td>
                    <td><?= h($loanClient->employment_type) ?></td>
                    <td><?= $this->Number->format($loanClient->monthly_income) ?></td>
                    <td><?= h($loanClient->income_currency) ?></td>
                    <td><?= h($loanClient->contact_phone) ?></td>
                    <td><?= h($loanClient->contact_email) ?></td>
                    <td><?= h($loanClient->status) ?></td>
                    <td><?= h($loanClient->created) ?></td>
                    <td><?= h($loanClient->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $loanClient->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $loanClient->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $loanClient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $loanClient->id)]) ?>
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