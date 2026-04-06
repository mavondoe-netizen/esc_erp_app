<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveApplication $leaveApplication
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Leave Application'), ['action' => 'edit', $leaveApplication->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Leave Application'), ['action' => 'delete', $leaveApplication->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveApplication->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Leave Applications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Leave Application'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leaveApplications view content">
            <h3><?= h($leaveApplication->status) ?></h3>
            <table>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $leaveApplication->hasValue('employee') ? $this->Html->link($leaveApplication->employee->employee_code, ['controller' => 'Employees', 'action' => 'view', $leaveApplication->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Leave Type') ?></th>
                    <td><?= $leaveApplication->hasValue('leave_type') ? $this->Html->link($leaveApplication->leave_type->name, ['controller' => 'LeaveTypes', 'action' => 'view', $leaveApplication->leave_type->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($leaveApplication->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($leaveApplication->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Days Requested') ?></th>
                    <td><?= $this->Number->format($leaveApplication->days_requested) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($leaveApplication->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($leaveApplication->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($leaveApplication->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($leaveApplication->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($leaveApplication->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>