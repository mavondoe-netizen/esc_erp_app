<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LeaveBalance> $leaveBalances
 */
?>
<div class="leaveBalances index content">
    <?= $this->Html->link(__('New Leave Balance'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Leave Balances') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id') ?></th>
                    <th><?= $this->Paginator->sort('leave_type_id') ?></th>
                    <th><?= $this->Paginator->sort('year') ?></th>
                    <th><?= $this->Paginator->sort('days_entitled') ?></th>
                    <th><?= $this->Paginator->sort('days_taken') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaveBalances as $leaveBalance): ?>
                <tr>
                    <td><?= $this->Number->format($leaveBalance->id) ?></td>
                    <td><?= $leaveBalance->hasValue('employee') ? $this->Html->link($leaveBalance->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $leaveBalance->employee->id]) : '' ?></td>
                    <td><?= $leaveBalance->hasValue('leave_type') ? $this->Html->link($leaveBalance->leave_type->name, ['controller' => 'LeaveTypes', 'action' => 'view', $leaveBalance->leave_type->id]) : '' ?></td>
                    <td><?= $this->Number->format($leaveBalance->year) ?></td>
                    <td><?= $this->Number->format($leaveBalance->days_entitled) ?></td>
                    <td><?= $this->Number->format($leaveBalance->days_taken) ?></td>
                    <td><?= h($leaveBalance->created) ?></td>
                    <td><?= h($leaveBalance->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $leaveBalance->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $leaveBalance->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $leaveBalance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveBalance->id)]) ?>
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