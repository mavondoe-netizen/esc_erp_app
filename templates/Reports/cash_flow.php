<?php
/**
 * @var \App\View\AppView $this
 * @var array $report
 * @var array $totals
 * @var string $startDate
 * @var string $endDate
 */
$this->assign('title', 'Statement of Cash Flows');
?>
<style>
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
        .acc-table { border-collapse: collapse; width: 100%; }
        .acc-table th, .acc-table td { border-bottom: 1px solid #ddd; padding: 8px; }
    }
    .filters { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    .acc-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .acc-table th, .acc-table td { padding: 10px; border-bottom: 1px solid #eee; text-align: left; }
    .acc-header { background: #fdfdfd; font-weight: bold; font-size: 1.1em; color: #333; }
    .acc-subtotal { font-weight: bold; text-align: right !important; border-top: 1px solid #ccc; font-size: 1.05em; }
    .acc-grand-total { font-weight: bold; font-size: 1.25em; border-top: 2px solid #000; border-bottom: 4px double #000; text-align: right !important; }
</style>

<div class="reports index content">
    <div class="no-print">
        <h3><?= __('Statement of Cash Flows (Indirect Method)') ?></h3>
        
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
            <div class="col-md-2" style="margin-top: 25px;">
                <?= $this->Form->button(__('Generate'), ['class' => 'button']) ?>
            </div>
            <div class="col-md-4 text-right" style="margin-top: 25px;">
                <button type="button" onclick="window.print()" class="button button-outline float-right">Print Statement</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <div class="print-area" style="padding: 20px; background: #fff;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="margin:0;">STATEMENT OF CASH FLOWS</h2>
            <h4 style="margin:5px 0; color: #555;">For the period: <?= h($startDate) ?> to <?= h($endDate) ?></h4>
        </div>

        <table class="acc-table no-dt">
            <!-- OPERATING ACTIVITIES -->
            <tr>
                <td colspan="2" class="acc-header" style="background:#e8f4f8;">CASH FLOWS FROM OPERATING ACTIVITIES</td>
            </tr>
            <tr>
                <td style="padding-left: 20px;"><strong>Net Income</strong></td>
                <td class="text-right" style="font-weight: bold;"><?= $this->Number->format($report['NetIncome'], ['places' => 2]) ?></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 20px; font-style: italic; color: #666;">Adjustments to reconcile net income to net cash provided by operating activities:</td>
            </tr>
            <?php foreach ($report['OperatingActivities'] as $accName => $data): ?>
            <tr>
                <td style="padding-left: 40px;">
                    Change in <?= $this->Html->link(h($accName), [
                        'action' => 'ledger',
                        '?' => [
                            'account_id' => $data['account_id'],
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'currency' => current($this->getRequest()->getQueryParams())['currency'] ?? 'USD'
                        ]
                    ], ['target' => '_blank']) ?>
                </td>
                <td class="text-right"><?= $this->Number->format($data['actual'], ['places' => 2]) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr style="background: #fdfdfd;">
                <td><strong>Net Cash Provided by (Used in) Operating Activities</strong></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['net_cash_operating'], ['places' => 2]) ?></td>
            </tr>

            <!-- SPACE -->
            <tr><td colspan="2" style="height: 30px; border:none;"></td></tr>

            <!-- FINANCING ACTIVITIES -->
            <tr>
                <td colspan="2" class="acc-header" style="background:#f4fce8;">CASH FLOWS FROM FINANCING ACTIVITIES</td>
            </tr>
            <?php if (empty($report['FinancingActivities'])): ?>
                <tr><td colspan="2" class="text-center text-muted">No financing activities recorded</td></tr>
            <?php endif; ?>
            <?php foreach ($report['FinancingActivities'] as $accName => $data): ?>
            <tr>
                <td style="padding-left: 40px;">
                    Change in <?= $this->Html->link(h($accName), [
                        'action' => 'ledger',
                        '?' => [
                            'account_id' => $data['account_id'],
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'currency' => current($this->getRequest()->getQueryParams())['currency'] ?? 'USD'
                        ]
                    ], ['target' => '_blank']) ?>
                </td>
                <td class="text-right"><?= $this->Number->format($data['actual'], ['places' => 2]) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr style="background: #fdfdfd;">
                <td><strong>Net Cash Provided by (Used in) Financing Activities</strong></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['net_cash_financing'], ['places' => 2]) ?></td>
            </tr>

            <!-- TOTAL CASH INCREASE -->
            <tr style="background: #fafafa;">
                <td style="font-size: 1.1em; padding-top: 20px; padding-bottom: 20px;"><strong>NET INCREASE (DECREASE) IN CASH</strong></td>
                <td class="acc-grand-total" style="padding-top: 20px; padding-bottom: 20px; <?= $totals['net_increase_cash'] >= 0 ? 'color: #38761d;' : 'color: #cc0000;' ?>">
                    <?= $this->Number->format($totals['net_increase_cash'], ['places' => 2]) ?>
                </td>
            </tr>
        </table>
    </div>
</div>
