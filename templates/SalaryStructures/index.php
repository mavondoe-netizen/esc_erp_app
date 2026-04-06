<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SalaryStructure> $salaryStructures
 */
?>
<div class="salaryStructures index content">
    <?= $this->Html->link(__('New Salary Structure'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Salary Structures') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('role_id') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('basic_salary') ?></th>
                    <th><?= $this->Paginator->sort('payment_frequency') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salaryStructures as $salaryStructure): ?>
                <tr>
                    <td><?= $this->Number->format($salaryStructure->id) ?></td>
                    <td><?= $salaryStructure->hasValue('user') ? $this->Html->link($salaryStructure->user->role_id, ['controller' => 'Users', 'action' => 'view', $salaryStructure->user->id]) : '' ?></td>
                    <td><?= $salaryStructure->hasValue('role') ? $this->Html->link($salaryStructure->role->name, ['controller' => 'Roles', 'action' => 'view', $salaryStructure->role->id]) : '' ?></td>
                    <td><?= h($salaryStructure->currency) ?></td>
                    <td><?= $this->Number->format($salaryStructure->basic_salary) ?></td>
                    <td><?= h($salaryStructure->payment_frequency) ?></td>
                    <td><?= h($salaryStructure->is_active) ?></td>
                    <td><?= h($salaryStructure->created) ?></td>
                    <td><?= h($salaryStructure->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $salaryStructure->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $salaryStructure->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $salaryStructure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salaryStructure->id)]) ?>
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