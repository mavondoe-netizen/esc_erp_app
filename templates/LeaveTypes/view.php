<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveType $leaveType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Leave Type'), ['action' => 'edit', $leaveType->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Leave Type'), ['action' => 'delete', $leaveType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveType->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Leave Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Leave Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="leaveTypes view content">
            <h3><?= h($leaveType->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($leaveType->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($leaveType->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Default Days Per Year') ?></th>
                    <td><?= $this->Number->format($leaveType->default_days_per_year) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($leaveType->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($leaveType->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $leaveType->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($leaveType->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Leave Applications') ?></h4>
                <?php if (!empty($leaveType->leave_applications)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Leave Type Id') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Days Requested') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($leaveType->leave_applications as $leaveApplication) : ?>
                        <tr>
                            <td><?= h($leaveApplication->id) ?></td>
                            <td><?= h($leaveApplication->employee_id) ?></td>
                            <td><?= h($leaveApplication->leave_type_id) ?></td>
                            <td><?= h($leaveApplication->start_date) ?></td>
                            <td><?= h($leaveApplication->end_date) ?></td>
                            <td><?= h($leaveApplication->days_requested) ?></td>
                            <td><?= h($leaveApplication->notes) ?></td>
                            <td><?= h($leaveApplication->status) ?></td>
                            <td><?= h($leaveApplication->created) ?></td>
                            <td><?= h($leaveApplication->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LeaveApplications', 'action' => 'view', $leaveApplication->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LeaveApplications', 'action' => 'edit', $leaveApplication->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LeaveApplications', 'action' => 'delete', $leaveApplication->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveApplication->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Leave Balances') ?></h4>
                <?php if (!empty($leaveType->leave_balances)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Leave Type Id') ?></th>
                            <th><?= __('Year') ?></th>
                            <th><?= __('Days Entitled') ?></th>
                            <th><?= __('Days Taken') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($leaveType->leave_balances as $leaveBalance) : ?>
                        <tr>
                            <td><?= h($leaveBalance->id) ?></td>
                            <td><?= h($leaveBalance->employee_id) ?></td>
                            <td><?= h($leaveBalance->leave_type_id) ?></td>
                            <td><?= h($leaveBalance->year) ?></td>
                            <td><?= h($leaveBalance->days_entitled) ?></td>
                            <td><?= h($leaveBalance->days_taken) ?></td>
                            <td><?= h($leaveBalance->created) ?></td>
                            <td><?= h($leaveBalance->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LeaveBalances', 'action' => 'view', $leaveBalance->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LeaveBalances', 'action' => 'edit', $leaveBalance->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LeaveBalances', 'action' => 'delete', $leaveBalance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $leaveBalance->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>