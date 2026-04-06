<?php
/**
 * @var \App\View\AppView $this
 * @var array $report
 * @var array $totals
 * @var string $startDate
 * @var string $endDate
 */
$this->assign('title', 'Income Statement');
?>
<style>
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
        .acc-table { border-collapse: collapse; width: 100%; }
        .acc-table th, .acc-table td { border-bottom: 1px solid #ddd; padding: 8px; }
        .acc-header { font-weight: bold; background: #eee; }
        .acc-total { font-weight: bold; border-top: 2px solid #000; border-bottom: 2px double #000; }
    }
    .filters { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    .acc-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .acc-table th, .acc-table td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
    .acc-header { background: #fdfdfd; font-weight: bold; font-size: 1.1em; color: #444; }
    .acc-subcategory { font-weight: bold; padding-left: 15px !important; color: #666; background: #fafafa; font-style: italic; }
    .acc-item { padding-left: 40px !important; }
    .acc-amount { text-align: right !important; width: 100px; }
    .acc-subtotal { font-weight: bold; text-align: right !important; border-top: 1px solid #ccc; background: #fafafa; }
    .acc-total { font-weight: bold; font-size: 1.1em; border-top: 2px solid #333; border-bottom: 3px double #333; text-align: right !important; }
    .var-pos { color: #2e7d32; font-weight: bold; }
    .var-neg { color: #d32f2f; font-weight: bold; }
    .acc-table th { background: #f0f0f0; border-bottom: 2px solid #ccc; }
</style>

<div class="reports index content">
    <div class="no-print">
        <h3><?= __('Income Statement (Profit & Loss)') ?></h3>
        
        <div class="filters">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row align-items-end']) ?>
            <div class="col-md-3">
                <?= $this->Form->control('start_date', [
                    'type' => 'date',
                    'value' => $startDate,
                    'label' => 'Start Date',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $this->Form->control('end_date', [
                    'type' => 'date',
                    'value' => $endDate,
                    'label' => 'End Date',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-md-2">
                <?= $this->Form->control('department_id', [
                    'type' => 'select',
                    'options' => $departments,
                    'empty' => 'All Departments',
                    'value' => $departmentId,
                    'label' => 'Department',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-md-2">
                <?= $this->Form->control('currency', [
                    'type' => 'select',
                    'options' => ['USD' => 'USD (Base)', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR', 'EUR' => 'EUR', 'GBP' => 'GBP'],
                    'value' => $targetCurrency ?? 'USD',
                    'label' => 'Currency',
                    'class' => 'form-control',
                    'empty' => false
                ]) ?>
            </div>
            <div class="col-md-2" style="margin-top: 25px;">
                <?= $this->Form->button(__('Generate'), ['class' => 'button']) ?>
            </div>
            <div class="col-md-4 text-right" style="margin-top: 25px;">
                <button onclick="window.print()" class="button button-outline float-right">Print Statement</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <div class="print-area" style="padding: 20px; background: #fff;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="margin:0;">COMPANY INCOME STATEMENT</h2>
            <?php if (!empty($departmentId) && isset($departments[(string)$departmentId])): ?>
                <h3 style="margin:5px 0;">Department: <?= h($departments[(string)$departmentId]) ?></h3>
            <?php endif; ?>
            <h4 style="margin:5px 0; color: #555;">For the period: <?= h($startDate) ?> to <?= h($endDate) ?></h4>
        </div>

        <table class="acc-table no-dt">
            <thead>
                <tr>
                    <th style="width: 250px;">Account Name</th>
                    <th class="acc-amount">Period Actual</th>
                    <th class="acc-amount">YTD Actual</th>
                    <th class="acc-amount">YTD Budget</th>
                    <th class="acc-amount">Variance ($)</th>
                    <th class="acc-amount">Var %</th>
                </tr>
            </thead>
            <!-- REVENUE -->
            <tr>
                <td colspan="6" class="acc-header">Revenue</td>
            </tr>
            <?php foreach ($report['Revenue'] as $sub => $accounts): ?>
                <tr>
                    <td colspan="6" class="acc-subcategory"><?= h($sub) ?></td>
                </tr>
                <?php foreach ($accounts as $accName => $values): ?>
                <?php 
                    $var = $values['ytd_actual'] - $values['ytd_budget'];
                    $varPct = $values['ytd_budget'] != 0 ? ($var / $values['ytd_budget']) * 100 : 0;
                    $class = $var >= 0 ? 'var-pos' : 'var-neg';
                ?>
                <tr>
                    <td class="acc-item">
                        <?= $this->Html->link(h($accName), [
                            'action' => 'ledger',
                            '?' => [
                                'account_id' => $values['account_id'],
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                                'currency' => $targetCurrency ?? 'USD'
                            ]
                        ], ['target' => '_blank']) ?>
                    </td>
                    <td class="acc-amount"><?= $this->Number->format($values['actual'], ['places' => 2]) ?></td>
                    <td class="acc-amount"><?= $this->Number->format($values['ytd_actual'], ['places' => 2]) ?></td>
                    <td class="acc-amount"><?= $this->Number->format($values['ytd_budget'], ['places' => 2]) ?></td>
                    <td class="acc-amount <?= $class ?>"><?= $this->Number->format($var, ['places' => 2]) ?></td>
                    <td class="acc-amount <?= $class ?>"><?= number_format($varPct, 1) ?>%</td>
                </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <td><strong>Total Revenue</strong></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['period_revenue'], ['places' => 2]) ?></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['ytd_revenue'], ['places' => 2]) ?></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['ytd_budget_revenue'], ['places' => 2]) ?></td>
                <?php 
                    $tVar = $totals['ytd_revenue'] - $totals['ytd_budget_revenue'];
                    $tVarPct = $totals['ytd_budget_revenue'] != 0 ? ($tVar / $totals['ytd_budget_revenue']) * 100 : 0;
                ?>
                <td class="acc-subtotal <?= $tVar >= 0 ? 'var-pos' : 'var-neg' ?>"><?= $this->Number->format($tVar, ['places' => 2]) ?></td>
                <td class="acc-subtotal"><?= number_format($tVarPct, 1) ?>%</td>
            </tr>

            <!-- COST OF SALES -->
            <tr>
                <td colspan="6" class="acc-header" style="padding-top: 20px;">Cost of Sales</td>
            </tr>
            <?php foreach ($report['CostOfSales'] as $sub => $accounts): ?>
                <tr>
                    <td colspan="6" class="acc-subcategory"><?= h($sub) ?></td>
                </tr>
                <?php foreach ($accounts as $accName => $values): ?>
                <?php 
                    $var = $values['ytd_budget'] - $values['ytd_actual']; // For costs, under budget is positive variance
                    $varPct = $values['ytd_budget'] != 0 ? ($var / $values['ytd_budget']) * 100 : 0;
                    $class = $var >= 0 ? 'var-pos' : 'var-neg';
                ?>
                <tr>
                    <td class="acc-item">
                        <?= $this->Html->link(h($accName), [
                            'action' => 'ledger',
                            '?' => [
                                'account_id' => $values['account_id'],
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                                'currency' => $targetCurrency ?? 'USD'
                            ]
                        ], ['target' => '_blank']) ?>
                    </td>
                    <td class="acc-amount"><?= $this->Number->format($values['actual'], ['places' => 2]) ?></td>
                    <td class="acc-amount"><?= $this->Number->format($values['ytd_actual'], ['places' => 2]) ?></td>
                    <td class="acc-amount"><?= $this->Number->format($values['ytd_budget'], ['places' => 2]) ?></td>
                    <td class="acc-amount <?= $class ?>"><?= $this->Number->format($var, ['places' => 2]) ?></td>
                    <td class="acc-amount <?= $class ?>"><?= number_format($varPct, 1) ?>%</td>
                </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <td><strong>Total Cost of Sales</strong></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['period_cogs'], ['places' => 2]) ?></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['ytd_cogs'], ['places' => 2]) ?></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['ytd_budget_cogs'], ['places' => 2]) ?></td>
                <?php 
                    $tVar = $totals['ytd_budget_cogs'] - $totals['ytd_cogs'];
                    $tVarPct = $totals['ytd_budget_cogs'] != 0 ? ($tVar / $totals['ytd_budget_cogs']) * 100 : 0;
                ?>
                <td class="acc-subtotal <?= $tVar >= 0 ? 'var-pos' : 'var-neg' ?>"><?= $this->Number->format($tVar, ['places' => 2]) ?></td>
                <td class="acc-subtotal"><?= number_format($tVarPct, 1) ?>%</td>
            </tr>

            <!-- GROSS PROFIT -->
            <tr style="background: #f4fce8;">
                <td style="font-size: 1.1em; font-weight: bold; padding-top: 15px;">GROSS PROFIT</td>
                <td class="acc-total" style="border-top: none; padding-top: 15px;"><?= $this->Number->format($totals['gross_profit'], ['places' => 2]) ?></td>
                <td class="acc-total" style="border-top: none; padding-top: 15px;"><?= $this->Number->format($totals['ytd_gross_profit'], ['places' => 2]) ?></td>
                <td class="acc-total" style="border-top: none; padding-top: 15px;"><?= $this->Number->format($totals['ytd_budget_gross_profit'], ['places' => 2]) ?></td>
                <?php 
                    $tVar = $totals['ytd_gross_profit'] - $totals['ytd_budget_gross_profit'];
                    $tVarPct = $totals['ytd_budget_gross_profit'] != 0 ? ($tVar / $totals['ytd_budget_gross_profit']) * 100 : 0;
                ?>
                <td class="acc-total <?= $tVar >= 0 ? 'var-pos' : 'var-neg' ?>"><?= $this->Number->format($tVar, ['places' => 2]) ?></td>
                <td class="acc-total"><?= number_format($tVarPct, 1) ?>%</td>
            </tr>

            <!-- EXPENSES -->
            <tr>
                <td colspan="6" class="acc-header" style="padding-top: 30px;">Operating Expenses</td>
            </tr>
            <?php foreach ($report['Expenses'] as $sub => $accounts): ?>
                <tr>
                    <td colspan="6" class="acc-subcategory"><?= h($sub) ?></td>
                </tr>
                <?php foreach ($accounts as $accName => $values): ?>
                <?php 
                    $var = $values['ytd_budget'] - $values['ytd_actual'];
                    $varPct = $values['ytd_budget'] != 0 ? ($var / $values['ytd_budget']) * 100 : 0;
                    $class = $var >= 0 ? 'var-pos' : 'var-neg';
                ?>
                <tr>
                    <td class="acc-item">
                        <?= $this->Html->link(h($accName), [
                            'action' => 'ledger',
                            '?' => [
                                'account_id' => $values['account_id'],
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                                'currency' => $targetCurrency ?? 'USD'
                            ]
                        ], ['target' => '_blank']) ?>
                    </td>
                    <td class="acc-amount"><?= $this->Number->format($values['actual'], ['places' => 2]) ?></td>
                    <td class="acc-amount"><?= $this->Number->format($values['ytd_actual'], ['places' => 2]) ?></td>
                    <td class="acc-amount"><?= $this->Number->format($values['ytd_budget'], ['places' => 2]) ?></td>
                    <td class="acc-amount <?= $class ?>"><?= $this->Number->format($var, ['places' => 2]) ?></td>
                    <td class="acc-amount <?= $class ?>"><?= number_format($varPct, 1) ?>%</td>
                </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <td><strong>Total Expenses</strong></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['period_expenses'], ['places' => 2]) ?></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['ytd_expenses'], ['places' => 2]) ?></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['ytd_budget_expenses'], ['places' => 2]) ?></td>
                <?php 
                    $tVar = $totals['ytd_budget_expenses'] - $totals['ytd_expenses'];
                    $tVarPct = $totals['ytd_budget_expenses'] != 0 ? ($tVar / $totals['ytd_budget_expenses']) * 100 : 0;
                ?>
                <td class="acc-subtotal <?= $tVar >= 0 ? 'var-pos' : 'var-neg' ?>"><?= $this->Number->format($tVar, ['places' => 2]) ?></td>
                <td class="acc-subtotal"><?= number_format($tVarPct, 1) ?>%</td>
            </tr>

            <!-- NET INCOME -->
            <tr style="background: #eef;">
                <td style="font-size: 1.2em; font-weight: bold; padding-top: 20px; padding-bottom: 20px;">NET INCOME</td>
                <td class="acc-total" style="padding-top: 20px; padding-bottom: 20px;"><?= $this->Number->format($totals['net_income'], ['places' => 2]) ?></td>
                <td class="acc-total" style="padding-top: 20px; padding-bottom: 20px;"><?= $this->Number->format($totals['ytd_net_income'], ['places' => 2]) ?></td>
                <td class="acc-total" style="padding-top: 20px; padding-bottom: 20px;"><?= $this->Number->format($totals['ytd_budget_net_income'], ['places' => 2]) ?></td>
                <?php 
                    $tVar = $totals['ytd_net_income'] - $totals['ytd_budget_net_income'];
                ?>
                <td class="acc-total <?= $tVar >= 0 ? 'var-pos' : 'var-neg' ?>"><?= $this->Number->format($tVar, ['places' => 2]) ?></td>
                <td class="acc-total"></td>
            </tr>
        </table>
    </div>
</div>
