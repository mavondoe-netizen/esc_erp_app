<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="users view content">
            <h3><?= h($user->email) ?></h3>
            <table>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $user->hasValue('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $user->hasValue('company') ? $this->Html->link($user->company->name, ['controller' => 'Companies', 'action' => 'view', $user->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $user->hasValue('employee') ? $this->Html->link($user->employee->first_name . ' ' . $user->employee->last_name, ['controller' => 'Employees', 'action' => 'view', $user->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Meetings') ?></h4>
                <?php if (!empty($user->meetings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Contact Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->meetings as $meeting) : ?>
                        <tr>
                            <td><?= h($meeting->id) ?></td>
                            <td><?= h($meeting->name) ?></td>
                            <td><?= h($meeting->contact_id) ?></td>
                            <td><?= h($meeting->user_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Meetings', 'action' => 'view', $meeting->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Meetings', 'action' => 'edit', $meeting->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Meetings', 'action' => 'delete', $meeting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meeting->id)]) ?>
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