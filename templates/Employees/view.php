<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Employee'), ['action' => 'edit', $employee->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Employee'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Employees'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Employee'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="employees view content">
            <h3><?= h($employee->employee_code) ?></h3>
            <table>
                <tr>
                    <th><?= __('Employee Code') ?></th>
                    <td><?= h($employee->employee_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($employee->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($employee->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Designation') ?></th>
                    <td><?= h($employee->designation) ?></td>
                </tr>
                <tr>
                    <th><?= __('National Identity') ?></th>
                    <td><?= h($employee->national_identity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $employee->hasValue('company') ? $this->Html->link($employee->company->name, ['controller' => 'Companies', 'action' => 'view', $employee->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Usd Bank') ?></th>
                    <td><?= h($employee->usd_bank) ?></td>
                </tr>
                <tr>
                    <th><?= __('Usd Branch') ?></th>
                    <td><?= h($employee->usd_branch) ?></td>
                </tr>
                <tr>
                    <th><?= __('Usd Account') ?></th>
                    <td><?= h($employee->usd_account) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zwg Bank') ?></th>
                    <td><?= h($employee->zwg_bank) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zwg Branch') ?></th>
                    <td><?= h($employee->zwg_branch) ?></td>
                </tr>
                <tr>
                    <th><?= __('Zwg Account') ?></th>
                    <td><?= h($employee->zwg_account) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($employee->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nssa Number') ?></th>
                    <td><?= $this->Number->format($employee->nssa_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tax Number') ?></th>
                    <td><?= $this->Number->format($employee->tax_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Basic Salary') ?></th>
                    <td><?= $this->Number->format($employee->basic_salary) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Of Birth') ?></th>
                    <td><?= h($employee->date_of_birth) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($employee->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($employee->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($employee->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Termination Date') ?></th>
                    <td><?= h($employee->termination_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Disabled') ?></th>
                    <td><?= $employee->disabled ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Blind') ?></th>
                    <td><?= $employee->is_blind ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Claims') ?></h4>
                <?php if (!empty($employee->claims)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Scheme') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Date Of Accident') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Benefit Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($employee->claims as $claim) : ?>
                        <tr>
                            <td><?= h($claim->id) ?></td>
                            <td><?= h($claim->name) ?></td>
                            <td><?= h($claim->scheme) ?></td>
                            <td><?= h($claim->employee_id) ?></td>
                            <td><?= h($claim->date_of_accident) ?></td>
                            <td><?= h($claim->description) ?></td>
                            <td><?= h($claim->benefit_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Claims', 'action' => 'view', $claim->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Claims', 'action' => 'edit', $claim->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Claims', 'action' => 'delete', $claim->id], ['confirm' => __('Are you sure you want to delete # {0}?', $claim->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Leave Applications') ?></h4>
                <?php if (!empty($employee->leave_applications)) : ?>
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
                        <?php foreach ($employee->leave_applications as $leaveApplication) : ?>
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
                <?php if (!empty($employee->leave_balances)) : ?>
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
                        <?php foreach ($employee->leave_balances as $leaveBalance) : ?>
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
            <div class="related">
                <h4><?= __('Related Payslips') ?></h4>
                <?php if (!empty($employee->payslips)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Pay Period Id') ?></th>
                            <th><?= __('Gross Pay') ?></th>
                            <th><?= __('Deductions') ?></th>
                            <th><?= __('Net Pay') ?></th>
                            <th><?= __('Exchange Rate') ?></th>
                            <th><?= __('Generated Date') ?></th>
                            <th><?= __('Basic Salary') ?></th>
                            <th><?= __('Allowances') ?></th>
                            <th><?= __('Bonuses') ?></th>
                            <th><?= __('Overtime') ?></th>
                            <th><?= __('Benefits') ?></th>
                            <th><?= __('Pension') ?></th>
                            <th><?= __('Nssa') ?></th>
                            <th><?= __('Medical Aid') ?></th>
                            <th><?= __('Medical Expenses') ?></th>
                            <th><?= __('Taxable Income') ?></th>
                            <th><?= __('Paye') ?></th>
                            <th><?= __('Tax Credits') ?></th>
                            <th><?= __('Aids Levy') ?></th>
                            <th><?= __('Total Tax') ?></th>
                            <th><?= __('Usd Gross') ?></th>
                            <th><?= __('Usd Deductions') ?></th>
                            <th><?= __('Usd Net') ?></th>
                            <th><?= __('Zwg Gross') ?></th>
                            <th><?= __('Zwg Deductions') ?></th>
                            <th><?= __('Zwg Net') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($employee->payslips as $payslip) : ?>
                        <tr>
                            <td><?= h($payslip->id) ?></td>
                            <td><?= h($payslip->employee_id) ?></td>
                            <td><?= h($payslip->pay_period_id) ?></td>
                            <td><?= h($payslip->gross_pay) ?></td>
                            <td><?= h($payslip->deductions) ?></td>
                            <td><?= h($payslip->net_pay) ?></td>
                            <td><?= h($payslip->exchange_rate) ?></td>
                            <td><?= h($payslip->generated_date) ?></td>
                            <td><?= h($payslip->basic_salary) ?></td>
                            <td><?= h($payslip->allowances) ?></td>
                            <td><?= h($payslip->bonuses) ?></td>
                            <td><?= h($payslip->overtime) ?></td>
                            <td><?= h($payslip->benefits) ?></td>
                            <td><?= h($payslip->pension) ?></td>
                            <td><?= h($payslip->nssa) ?></td>
                            <td><?= h($payslip->medical_aid) ?></td>
                            <td><?= h($payslip->medical_expenses) ?></td>
                            <td><?= h($payslip->taxable_income) ?></td>
                            <td><?= h($payslip->paye) ?></td>
                            <td><?= h($payslip->tax_credits) ?></td>
                            <td><?= h($payslip->aids_levy) ?></td>
                            <td><?= h($payslip->total_tax) ?></td>
                            <td><?= h($payslip->usd_gross) ?></td>
                            <td><?= h($payslip->usd_deductions) ?></td>
                            <td><?= h($payslip->usd_net) ?></td>
                            <td><?= h($payslip->zwg_gross) ?></td>
                            <td><?= h($payslip->zwg_deductions) ?></td>
                            <td><?= h($payslip->zwg_net) ?></td>
                            <td><?= h($payslip->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Payslips', 'action' => 'view', $payslip->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Payslips', 'action' => 'edit', $payslip->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payslips', 'action' => 'delete', $payslip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payslip->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($employee->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Role Id') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Department Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($employee->users as $user) : ?>
                        <tr>
                            <td><?= h($user->id) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td><?= h($user->password) ?></td>
                            <td><?= h($user->role_id) ?></td>
                            <td><?= h($user->employee_id) ?></td>
                            <td><?= h($user->company_id) ?></td>
                            <td><?= h($user->department_id) ?></td>
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