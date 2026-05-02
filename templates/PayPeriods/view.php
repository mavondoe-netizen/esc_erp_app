<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PayPeriod $payPeriod
 */
?>
<div class="row">
    <aside class="column print-hidden" style="flex: 0 0 20%; max-width: 20%;">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pay Period'), ['action' => 'edit', $payPeriod->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Generate Payslips'), ['controller' => 'Payslips', 'action' => 'generate', '?' => ['pay_period_id' => $payPeriod->id]], ['class' => 'side-nav-item', 'style' => 'font-weight: bold; color: #2e6c80;']) ?>
            <?= $this->Form->postLink(__('Delete Pay Period'), ['action' => 'delete', $payPeriod->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payPeriod->id), 'class' => 'side-nav-item']) ?>
            <hr>
            <?= $this->Html->link(__('List Pay Periods'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="payPeriods view content">
            <h3>Pay Period: <?= h($payPeriod->name) ?></h3>
            <div class="row">
                <div class="column column-50">
                    <table>
                        <tr>
                            <th><?= __('Status') ?></th>
                            <td><span class="badge" style="background: #2e6c80; color: white; padding: 2px 8px; border-radius: 4px;"><?= h($payPeriod->status) ?></span></td>
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
                </div>
                <div class="column column-50" style="text-align: right;">
                    <div style="background: #f9f9fa; padding: 20px; border: 1px solid #ddd; border-radius: 4px;">
                        <h4 style="margin: 0;"><?= count($payPeriod->payslips) ?></h4>
                        <p style="margin: 0; color: #777;">Payslips Generated</p>
                    </div>
                </div>
            </div>

            <div class="related" style="margin-top: 40px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin: 0;"><?= __('Related Payslips') ?></h4>
                    <?= $this->Html->link(__('Bulk Generate'), ['controller' => 'Payslips', 'action' => 'generate', '?' => ['pay_period_id' => $payPeriod->id]], ['class' => 'button button-outline']) ?>
                </div>
                
                <?php if (!empty($payPeriod->payslips)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?= __('Employee') ?></th>
                                <th><?= __('Code') ?></th>
                                <th style="text-align: right;"><?= __('Gross Pay') ?></th>
                                <th style="text-align: right;"><?= __('Deductions') ?></th>
                                <th style="text-align: right;"><?= __('Net Pay') ?></th>
                                <th style="text-align: center;"><?= __('Date') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payPeriod->payslips as $payslip) : ?>
                            <tr>
                                <td><?= $payslip->hasValue('employee') ? h($payslip->employee->first_name . ' ' . $payslip->employee->last_name) : 'Unknown' ?></td>
                                <td><?= $payslip->hasValue('employee') ? h($payslip->employee->employee_code) : '' ?></td>
                                <td style="text-align: right;"><?= $this->Number->currency($payslip->gross_pay, 'USD') ?></td>
                                <td style="text-align: right;"><?= $this->Number->currency($payslip->deductions, 'USD') ?></td>
                                <td style="text-align: right;"><strong><?= $this->Number->currency($payslip->net_pay, 'USD') ?></strong></td>
                                <td style="text-align: center;"><?= h($payslip->generated_date) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Payslips', 'action' => 'view', $payslip->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Payslips', 'action' => 'edit', $payslip->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payslips', 'action' => 'delete', $payslip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payslip->id)]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px; background: #fdfdfd; border: 1px dashed #ccc; border-radius: 4px;">
                        <p style="color: #888; font-style: italic;">No payslips have been generated for this period yet.</p>
                        <?= $this->Html->link(__('Generate Now'), ['controller' => 'Payslips', 'action' => 'generate', '?' => ['pay_period_id' => $payPeriod->id]], ['class' => 'button']) ?>
                    </div>
                <?php endif; ?>
            <div class="related" style="margin-top: 40px;">
                <h4><?= __('Ledger Transactions') ?></h4>
                <?php if (!empty($payPeriod->transactions)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?= __('Date') ?></th>
                                <th><?= __('Description') ?></th>
                                <th><?= __('Account') ?></th>
                                <th style="text-align: right;"><?= __('Amount') ?></th>
                                <th><?= __('Currency') ?></th>
                                <th style="text-align: right;"><?= __('ZWG') ?></th>
                                <th><?= __('Type') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payPeriod->transactions as $transaction) : ?>
                            <tr>
                                <td><?= h($transaction->date) ?></td>
                                <td><?= h($transaction->description) ?></td>
                                <td><?= $transaction->hasValue('account') ? h($transaction->account->name) : 'Unknown' ?></td>
                                <td style="text-align: right;"><?= $this->Number->format($transaction->amount) ?></td>
                                <td><?= h($transaction->currency) ?></td>
                                <td style="text-align: right;"><?= $this->Number->format($transaction->zwg) ?></td>
                                <td>
                                    <span class="badge" style="background: <?= strtolower($transaction->type) === 'debit' ? '#27ae60' : '#2980b9' ?>; color: white; padding: 2px 6px; border-radius: 3px; font-size: 0.85em;">
                                        <?= h($transaction->type) ?>
                                    </span>
                                </td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Transactions', 'action' => 'view', $transaction->id]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <p class="text-muted" style="font-style: italic;">No ledger transactions have been posted for this period. Posting usually happens during rollover.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>