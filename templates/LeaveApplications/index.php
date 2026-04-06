<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LeaveApplication> $leaveApplications
 */
?>
<div class="leaveApplications index content">
    <?= $this->Html->link(__('New Leave Application'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Leave Applications') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="select-all-rows"></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id') ?></th>
                    <th><?= $this->Paginator->sort('leave_type_id') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('days_requested') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaveApplications as $leaveApplication): ?>
                <tr>
                    <td><input type="checkbox" class="row-checkbox" value="<?= $leaveApplication->id ?>"></td>
                    <td><?= $this->Number->format($leaveApplication->id) ?></td>
                    <td><?= $leaveApplication->hasValue('employee') ? $this->Html->link($leaveApplication->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $leaveApplication->employee->id]) : '' ?></td>
                    <td><?= $leaveApplication->hasValue('leave_type') ? $this->Html->link($leaveApplication->leave_type->name, ['controller' => 'LeaveTypes', 'action' => 'view', $leaveApplication->leave_type->id]) : '' ?></td>
                    <td><?= h($leaveApplication->start_date) ?></td>
                    <td><?= h($leaveApplication->end_date) ?></td>
                    <td><?= $this->Number->format($leaveApplication->days_requested) ?></td>
                    <td><?= h($leaveApplication->status) ?></td>
                    <td><?= h($leaveApplication->created) ?></td>
                    <td><?= h($leaveApplication->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $leaveApplication->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $leaveApplication->id]) ?>
                        <?php if ($leaveApplication->status !== 'Approved'): ?>
                            <?= $this->Form->postLink(__('Approve'), ['action' => 'approve', $leaveApplication->id], ['confirm' => __('Are you sure you want to approve this application?')]) ?>
                        <?php endif; ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $leaveApplication->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveApplication->id)]) ?>
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