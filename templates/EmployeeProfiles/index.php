<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\EmployeeProfile> $employeeProfiles
 */
?>
<div class="employeeProfiles index content">
    <?= $this->Html->link(__('New Employee Profile'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Employee Profiles') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id_number') ?></th>
                    <th><?= $this->Paginator->sort('tax_number') ?></th>
                    <th><?= $this->Paginator->sort('social_security_number') ?></th>
                    <th><?= $this->Paginator->sort('hire_date') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employeeProfiles as $employeeProfile): ?>
                <tr>
                    <td><?= $this->Number->format($employeeProfile->id) ?></td>
                    <td><?= $employeeProfile->hasValue('user') ? $this->Html->link($employeeProfile->user->role_id, ['controller' => 'Users', 'action' => 'view', $employeeProfile->user->id]) : '' ?></td>
                    <td><?= h($employeeProfile->employee_id_number) ?></td>
                    <td><?= h($employeeProfile->tax_number) ?></td>
                    <td><?= h($employeeProfile->social_security_number) ?></td>
                    <td><?= h($employeeProfile->hire_date) ?></td>
                    <td><?= h($employeeProfile->created) ?></td>
                    <td><?= h($employeeProfile->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $employeeProfile->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employeeProfile->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employeeProfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeProfile->id)]) ?>
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