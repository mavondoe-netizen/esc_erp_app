<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SalaryStructure $salaryStructure
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Salary Structure'), ['action' => 'edit', $salaryStructure->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Salary Structure'), ['action' => 'delete', $salaryStructure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salaryStructure->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Salary Structures'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Salary Structure'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="salaryStructures view content">
            <h3><?= h($salaryStructure->currency) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $salaryStructure->hasValue('user') ? $this->Html->link($salaryStructure->user->role_id, ['controller' => 'Users', 'action' => 'view', $salaryStructure->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $salaryStructure->hasValue('role') ? $this->Html->link($salaryStructure->role->name, ['controller' => 'Roles', 'action' => 'view', $salaryStructure->role->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency') ?></th>
                    <td><?= h($salaryStructure->currency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Frequency') ?></th>
                    <td><?= h($salaryStructure->payment_frequency) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($salaryStructure->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Basic Salary') ?></th>
                    <td><?= $this->Number->format($salaryStructure->basic_salary) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($salaryStructure->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($salaryStructure->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $salaryStructure->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Payroll Records') ?></h4>
                <?php if (!empty($salaryStructure->payroll_records)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Salary Structure Id') ?></th>
                            <th><?= __('Payroll Month') ?></th>
                            <th><?= __('Base Salary Amount') ?></th>
                            <th><?= __('Total Earnings') ?></th>
                            <th><?= __('Total Deductions') ?></th>
                            <th><?= __('Net Pay') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($salaryStructure->payroll_records as $payrollRecord) : ?>
                        <tr>
                            <td><?= h($payrollRecord->id) ?></td>
                            <td><?= h($payrollRecord->user_id) ?></td>
                            <td><?= h($payrollRecord->salary_structure_id) ?></td>
                            <td><?= h($payrollRecord->payroll_month) ?></td>
                            <td><?= h($payrollRecord->base_salary_amount) ?></td>
                            <td><?= h($payrollRecord->total_earnings) ?></td>
                            <td><?= h($payrollRecord->total_deductions) ?></td>
                            <td><?= h($payrollRecord->net_pay) ?></td>
                            <td><?= h($payrollRecord->status) ?></td>
                            <td><?= h($payrollRecord->currency) ?></td>
                            <td><?= h($payrollRecord->created) ?></td>
                            <td><?= h($payrollRecord->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PayrollRecords', 'action' => 'view', $payrollRecord->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PayrollRecords', 'action' => 'edit', $payrollRecord->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PayrollRecords', 'action' => 'delete', $payrollRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payrollRecord->id)]) ?>
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