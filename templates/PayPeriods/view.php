<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PayPeriod $payPeriod
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pay Period'), ['action' => 'edit', $payPeriod->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pay Period'), ['action' => 'delete', $payPeriod->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payPeriod->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pay Periods'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pay Period'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="payPeriods view content">
            <h3><?= h($payPeriod->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($payPeriod->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($payPeriod->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($payPeriod->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($payPeriod->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($payPeriod->end_date) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Payslips') ?></h4>
                <?php if (!empty($payPeriod->payslips)) : ?>
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
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($payPeriod->payslips as $payslip) : ?>
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
        </div>
    </div>
</div>