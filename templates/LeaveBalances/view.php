<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveBalance $leaveBalance
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Leave Balance'), ['action' => 'edit', $leaveBalance->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Leave Balance'), ['action' => 'delete', $leaveBalance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveBalance->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Leave Balances'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Leave Balance'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leaveBalances view content">
            <h3><?= h($leaveBalance->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $leaveBalance->hasValue('employee') ? $this->Html->link($leaveBalance->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $leaveBalance->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Leave Type') ?></th>
                    <td><?= $leaveBalance->hasValue('leave_type') ? $this->Html->link($leaveBalance->leave_type->name, ['controller' => 'LeaveTypes', 'action' => 'view', $leaveBalance->leave_type->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($leaveBalance->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Year') ?></th>
                    <td><?= $this->Number->format($leaveBalance->year) ?></td>
                </tr>
                <tr>
                    <th><?= __('Days Entitled') ?></th>
                    <td><?= $this->Number->format($leaveBalance->days_entitled) ?></td>
                </tr>
                <tr>
                    <th><?= __('Days Taken') ?></th>
                    <td><?= $this->Number->format($leaveBalance->days_taken) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($leaveBalance->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($leaveBalance->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>