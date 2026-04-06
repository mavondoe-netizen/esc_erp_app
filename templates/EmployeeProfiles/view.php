<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeProfile $employeeProfile
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Employee Profile'), ['action' => 'edit', $employeeProfile->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Employee Profile'), ['action' => 'delete', $employeeProfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeProfile->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Employee Profiles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Employee Profile'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="employeeProfiles view content">
            <h3><?= h($employeeProfile->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $employeeProfile->hasValue('user') ? $this->Html->link($employeeProfile->user->role_id, ['controller' => 'Users', 'action' => 'view', $employeeProfile->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Employee Id Number') ?></th>
                    <td><?= h($employeeProfile->employee_id_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tax Number') ?></th>
                    <td><?= h($employeeProfile->tax_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Social Security Number') ?></th>
                    <td><?= h($employeeProfile->social_security_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($employeeProfile->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hire Date') ?></th>
                    <td><?= h($employeeProfile->hire_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($employeeProfile->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($employeeProfile->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>