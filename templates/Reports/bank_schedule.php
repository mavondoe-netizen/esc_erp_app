<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $payPeriods
 * @var string $payPeriodId
 * @var string $currency
 * @var array $bankSchedule
 * @var float $totalTransfer
 */
?>

<div class="reports bank-schedule content">
    <h3><?= __('Bank Schedule') ?></h3>

    <div class="row align-items-center" style="margin-bottom: 2rem;">
        <div class="column column-80">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'inline-form', 'style' => 'display: flex; gap: 15px; align-items: flex-end;']) ?>
                <div style="flex: 2;">
                    <?= $this->Form->control('pay_period_id', [
                        'options' => $payPeriods,
                        'default' => $payPeriodId,
                        'empty' => 'Select Pay Period',
                        'label' => 'Pay Period'
                    ]) ?>
                </div>
                <div style="flex: 1;">
                    <?= $this->Form->control('currency', [
                        'options' => ['USD' => 'USD', 'ZWG' => 'ZWG'],
                        'default' => $currency,
                        'label' => 'Transfer Currency'
                    ]) ?>
                </div>
                <div style="flex: 1;">
                    <?= $this->Form->button(__('Generate Schedule'), ['type' => 'submit', 'class' => 'button']) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
        <div class="column column-30" style="text-align: right;">
             <button type="button" class="button button-outline" onclick="exportTableToCSV('bank_schedule_<?= date('Ymd_His') ?>.csv', 'table.table')">Export CSV</button>
             <button class="button button-outline" onclick="window.print()">Print Transfer List</button>
        </div>
    </div>

    <?php if (empty($bankSchedule) && $payPeriodId): ?>
        <div class="message notice">
            <?= __('No employees found with active net pay for the selected currency in this Pay Period.') ?>
        </div>
    <?php elseif ($payPeriodId): ?>

        <div style="margin-bottom: 2rem; padding: 1rem; background: #f4f6f8; border-radius: 4px; border-left: 5px solid #2e6c80;">
            <h4 style="margin: 0; color: #2e6c80;">Total Batch Transfer: <?= $currency ?> <?= number_format($totalTransfer, 2) ?></h4>
        </div>

        <?php foreach ($bankSchedule as $bankName => $data): ?>
            <div class="bank-group" style="margin-bottom: 3rem;">
                <h4 style="border-bottom: 2px solid #ddd; padding-bottom: 5px;">
                    <?= h($bankName) ?> 
                </h4>
                
                <table class="table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f9f9f9;">
                            <th style="padding: 10px; text-align: left; border: 1px solid #eee;">Employee Code</th>
                            <th style="padding: 10px; text-align: left; border: 1px solid #eee;">Account Name</th>
                            <th style="padding: 10px; text-align: left; border: 1px solid #eee;">Branch</th>
                            <th style="padding: 10px; text-align: left; border: 1px solid #eee;">Account Number</th>
                            <th style="padding: 10px; text-align: right; border: 1px solid #eee;">Net Transfer Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['employees'] as $emp): ?>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #eee;"><?= h($emp['employee_code']) ?></td>
                                <td style="padding: 8px; border: 1px solid #eee;"><?= h($emp['name']) ?></td>
                                <td style="padding: 8px; border: 1px solid #eee;"><?= h($emp['branch']) ?></td>
                                <td style="padding: 8px; border: 1px solid #eee;"><?= h($emp['account']) ?></td>
                                <td style="padding: 8px; border: 1px solid #eee; text-align: right; font-family: monospace;">
                                    <?= number_format($emp['net_pay'], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f1f1f1; font-weight: bold;">
                            <td colspan="4" style="padding: 10px; text-align: right; border: 1px solid #ddd;">Total for <?= h($bankName) ?></td>
                            <td style="padding: 10px; text-align: right; border: 1px solid #ddd; font-family: monospace;">
                                <?= number_format($data['total'], 2) ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .bank-schedule, .bank-schedule * {
        visibility: visible;
    }
    .bank-schedule {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .inline-form, .button-outline {
        display: none !important;
    }
    .bank-group {
        page-break-inside: avoid;
    }
}
</style>

<?= $this->element('export_csv') ?>
