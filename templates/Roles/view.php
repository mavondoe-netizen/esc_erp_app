<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Roles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Role'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="roles view content">
            <h3><?= h($role->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($role->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $role->hasValue('company') ? $this->Html->link($role->company->name, ['controller' => 'Companies', 'action' => 'view', $role->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($role->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($role->created) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Approval Flows') ?></h4>
                <?php if (!empty($role->approval_flows)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Module Name') ?></th>
                            <th><?= __('Level') ?></th>
                            <th><?= __('Role Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($role->approval_flows as $approvalFlow) : ?>
                        <tr>
                            <td><?= h($approvalFlow->id) ?></td>
                            <td><?= h($approvalFlow->module_name) ?></td>
                            <td><?= h($approvalFlow->level) ?></td>
                            <td><?= h($approvalFlow->role_id) ?></td>
                            <td><?= h($approvalFlow->description) ?></td>
                            <td><?= h($approvalFlow->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ApprovalFlows', 'action' => 'view', $approvalFlow->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ApprovalFlows', 'action' => 'edit', $approvalFlow->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ApprovalFlows', 'action' => 'delete', $approvalFlow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $approvalFlow->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Permissions') ?></h4>
                <?php if (!empty($role->permissions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Role Id') ?></th>
                            <th><?= __('Model') ?></th>
                            <th><?= __('Can Create') ?></th>
                            <th><?= __('Can Read') ?></th>
                            <th><?= __('Can Update') ?></th>
                            <th><?= __('Can Delete') ?></th>
                            <th><?= __('Can Approve') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($role->permissions as $permission) : ?>
                        <tr>
                            <td><?= h($permission->id) ?></td>
                            <td><?= h($permission->role_id) ?></td>
                            <td><?= h($permission->model) ?></td>
                            <td><?= h($permission->can_create) ?></td>
                            <td><?= h($permission->can_read) ?></td>
                            <td><?= h($permission->can_update) ?></td>
                            <td><?= h($permission->can_delete) ?></td>
                            <td><?= h($permission->can_approve) ?></td>
                            <td><?= h($permission->created) ?></td>
                            <td><?= h($permission->modified) ?></td>
                            <td><?= h($permission->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Permissions', 'action' => 'view', $permission->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Permissions', 'action' => 'edit', $permission->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Permissions', 'action' => 'delete', $permission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permission->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Salary Structures') ?></h4>
                <?php if (!empty($role->salary_structures)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Role Id') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Basic Salary') ?></th>
                            <th><?= __('Payment Frequency') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($role->salary_structures as $salaryStructure) : ?>
                        <tr>
                            <td><?= h($salaryStructure->id) ?></td>
                            <td><?= h($salaryStructure->user_id) ?></td>
                            <td><?= h($salaryStructure->role_id) ?></td>
                            <td><?= h($salaryStructure->currency) ?></td>
                            <td><?= h($salaryStructure->basic_salary) ?></td>
                            <td><?= h($salaryStructure->payment_frequency) ?></td>
                            <td><?= h($salaryStructure->is_active) ?></td>
                            <td><?= h($salaryStructure->created) ?></td>
                            <td><?= h($salaryStructure->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SalaryStructures', 'action' => 'view', $salaryStructure->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SalaryStructures', 'action' => 'edit', $salaryStructure->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SalaryStructures', 'action' => 'delete', $salaryStructure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salaryStructure->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($role->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Role Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($role->users as $user) : ?>
                        <tr>
                            <td><?= h($user->id) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td><?= h($user->password) ?></td>
                            <td><?= h($user->role_id) ?></td>
                            <td><?= h($user->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $user->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $user->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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