<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Payslip> $payslips
 */
$this->assign('title', 'ZIMRA PAYE Return');
?>
<style>
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
        table { font-size: 10px; width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000 !important; padding: 4px !important; }
    }
    .filters { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    .table-totals { background: #eef; font-weight: bold; }
</style>

<div class="reports index content">
    <div class="no-print">
        <h3><?= __('ZIMRA PAYE Return Report') ?></h3>
        
        <div class="filters">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row align-items-end']) ?>
            <div class="col-md-4">
                <?= $this->Form->control('pay_period_id', [
                    'options' => $payPeriods, 
                    'empty' => 'Select Pay Period...',
                    'value' => $payPeriodId,
                    'label' => 'Filter by Pay Period',
                    'class' => 'form-select'
                ]) ?>
            </div>
            <div class="col-md-2" style="margin-top: 25px;">
                <?= $this->Form->button(__('Generate'), ['class' => 'button']) ?>
            </div>
            <div class="col-md-6 text-right" style="margin-top: 25px;">
                <button type="button" onclick="exportTableToCSV('zimra_paye_<?= date('Ymd_His') ?>.csv', 'table#dynamicResultTable')" class="button button-outline float-right" style="margin-left: 10px;">Export CSV</button>
                <button type="button" onclick="window.print()" class="button button-outline float-right">Print Report</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <?php if ($payPeriodId && !empty($payslips)): ?>
    <div class="print-area">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2>ZIMRA P2 FORM - EMPLOYER'S MONTHLY SCHEDULE</h2>
            <h4>Pay Period: <?= h(isset($payPeriods[(string)$payPeriodId]) ? $payPeriods[(string)$payPeriodId] : 'Unknown') ?></h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped no-dt" id="dynamicResultTable" style="width: 100%;">
                <thead style="background-color: #f1f1f1;">
                    <tr>
                        <th>#</th>
                        <th>Emp Code</th>
                        <th>Employee Name</th>
                        <th>National ID</th>
                        <th class="text-right">Basic Salary</th>
                        <th class="text-right">Allowances</th>
                        <th class="text-right">Gross Pay</th>
                        <th class="text-right">NSSA</th>
                        <th class="text-right">Pension</th>
                        <th class="text-right">Medical</th>
                        <th class="text-right">Taxable Income</th>
                        <th class="text-right">PAYE</th>
                        <th class="text-right">AIDS Levy</th>
                        <th class="text-right">Total Tax</th>
                        <th class="text-right">Net Pay</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; foreach ($payslips as $slip): ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= h($slip->employee->employee_code) ?></td>
                        <td><?= h($slip->employee->first_name . ' ' . $slip->employee->last_name) ?></td>
                        <td><?= h($slip->employee->national_id) ?></td>
                        <td class="text-right"><?= $this->Number->format($slip->basic_salary, ['places' => 2]) ?></td>
                        <td class="text-right"><?= $this->Number->format($slip->allowances, ['places' => 2]) ?></td>
                        <td class="text-right"><?= $this->Number->format($slip->gross_pay, ['places' => 2]) ?></td>
                        <td class="text-right"><?= $this->Number->format($slip->nssa, ['places' => 2]) ?></td>
                        <td class="text-right"><?= $this->Number->format($slip->pension, ['places' => 2]) ?></td>
                        <td class="text-right"><?= $this->Number->format($slip->medical_aid, ['places' => 2]) ?></td>
                        <td class="text-right" style="background:#fffcf0; font-weight:bold;"><?= $this->Number->format($slip->taxable_income, ['places' => 2]) ?></td>
                        <td class="text-right text-danger"><?= $this->Number->format($slip->paye, ['places' => 2]) ?></td>
                        <td class="text-right text-warning"><?= $this->Number->format($slip->aids_levy, ['places' => 2]) ?></td>
                        <td class="text-right text-danger" style="font-weight:bold;"><?= $this->Number->format((float)$slip->paye + (float)$slip->aids_levy, ['places' => 2]) ?></td>
                        <td class="text-right text-success" style="font-weight:bold;"><?= $this->Number->format($slip->net_pay, ['places' => 2]) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-totals text-right">
                        <td colspan="4" class="text-center"><strong>TOTALS</strong></td>
                        <td><?= $this->Number->format($totals['basic_salary'], ['places' => 2]) ?></td>
                        <td><?= $this->Number->format($totals['allowances'], ['places' => 2]) ?></td>
                        <td><?= $this->Number->format($totals['gross_pay'], ['places' => 2]) ?></td>
                        <td><?= $this->Number->format($totals['nssa'], ['places' => 2]) ?></td>
                        <td><?= $this->Number->format($totals['pension'], ['places' => 2]) ?></td>
                        <td><?= $this->Number->format($totals['medical_aid'], ['places' => 2]) ?></td>
                        <td><?= $this->Number->format($totals['taxable_income'], ['places' => 2]) ?></td>
                        <td><?= $this->Number->format($totals['paye'], ['places' => 2]) ?></td>
                        <td><?= $this->Number->format($totals['aids_levy'], ['places' => 2]) ?></td>
                        <td style="color:red; font-size:1.1em;"><?= $this->Number->format($totals['total_tax'], ['places' => 2]) ?></td>
                        <td style="color:green; font-size:1.1em;"><?= $this->Number->format($totals['net_pay'], ['places' => 2]) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div style="margin-top: 40px; text-align: right;">
            <p><strong>Total PAYE Remittance Due: </strong> <span style="font-size: 1.5em; border-bottom: 2px double #000;"><?= $this->Number->format($totals['total_tax'], ['places' => 2]) ?></span></p>
            <br/><br/>
            <p>Authorized Signature: ______________________ Date: ______________</p>
        </div>
    </div>
    <?php elseif ($payPeriodId): ?>
        <div class="message info">No payroll data found for the selected Pay Period.</div>
    <?php else: ?>
        <div class="message info">Please select a Pay Period to generate the ZIMRA Return.</div>
    <?php endif; ?>
</div>

<?= $this->element('export_csv') ?>
