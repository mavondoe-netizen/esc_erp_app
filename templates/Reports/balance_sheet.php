<?php
/**
 * @var \App\View\AppView $this
 * @var array $report
 * @var array $totals
 * @var string $endDate
 */
$this->assign('title', 'Statement of Financial Position');
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
    .acc-subcategory { font-weight: bold; padding-left: 15px !important; color: #666; background: #fafafa; font-style: italic; }
    .acc-item { padding-left: 40px !important; }
    .acc-amount { text-align: right !important; }
    .acc-subtotal { font-weight: bold; text-align: right !important; border-top: 1px solid #ccc; font-size: 1.05em; }
    .acc-grand-total { font-weight: bold; font-size: 1.25em; border-top: 2px solid #000; border-bottom: 4px double #000; text-align: right !important; }
</style>

<div class="reports index content">
    <div class="no-print">
        <h3><?= __('Statement of Financial Position (Balance Sheet)') ?></h3>
        
        <div class="filters">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row align-items-end']) ?>
            <div class="col-md-3">
                <?= $this->Form->control('end_date', [
                    'type' => 'date',
                    'value' => $endDate,
                    'label' => 'As Of Date',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-md-2" style="margin-top: 25px;">
                <?= $this->Form->button(__('Generate'), ['class' => 'button']) ?>
            </div>
            <div class="col-md-7 text-right" style="margin-top: 25px;">
                <button type="button" onclick="exportTableToCSV('balance_sheet_<?= date('Ymd_His') ?>.csv')" class="button button-outline float-right" style="margin-left: 10px;">Export CSV</button>
                <button type="button" onclick="window.print()" class="button button-outline float-right">Print Statement</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <div class="print-area" style="padding: 20px; background: #fff;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="margin:0;">STATEMENT OF FINANCIAL POSITION</h2>
            <h4 style="margin:5px 0; color: #555;">As of <?= h($endDate) ?></h4>
        </div>

        <table class="acc-table no-dt">
            <!-- ASSETS -->
            <tr>
                <td colspan="2" class="acc-header" style="background:#e8f4f8;">ASSETS</td>
            </tr>
            <?php if (empty($report['Assets'])): ?>
                <tr><td colspan="2" class="text-center text-muted">No assets recorded</td></tr>
            <?php endif; ?>
            <?php foreach ($report['Assets'] as $sub => $accounts): ?>
                <tr>
                    <td colspan="2" class="acc-subcategory"><?= h($sub) ?></td>
                </tr>
                <?php foreach ($accounts as $accName => $data): ?>
                <?php if (round($data['actual'], 2) != 0): ?>
                <tr>
                    <td class="acc-item">
                        <?= $this->Html->link(h($accName), [
                            'action' => 'ledger',
                            '?' => [
                                'account_id' => $data['account_id'],
                                'start_date' => date('Y-01-01', strtotime($endDate)),
                                'end_date' => $endDate,
                                'currency' => current($this->getRequest()->getQueryParams())['currency'] ?? 'USD'
                            ]
                        ], ['target' => '_blank']) ?>
                    </td>
                    <td class="acc-amount"><?= $this->Number->format($data['actual'], ['places' => 2]) ?></td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <td style="font-size: 1.1em;"><strong>TOTAL ASSETS</strong></td>
                <td class="acc-grand-total" style="color: #0b5394;"><?= $this->Number->format($totals['total_assets'], ['places' => 2]) ?></td>
            </tr>

            <!-- SPACE -->
            <tr><td colspan="2" style="height: 30px; border:none;"></td></tr>

            <!-- LIABILITIES -->
            <tr>
                <td colspan="2" class="acc-header" style="background:#fce8e8;">LIABILITIES</td>
            </tr>
            <?php if (empty($report['Liabilities'])): ?>
                <tr><td colspan="2" class="text-center text-muted">No liabilities recorded</td></tr>
            <?php endif; ?>
            <?php foreach ($report['Liabilities'] as $sub => $accounts): ?>
                <tr>
                    <td colspan="2" class="acc-subcategory"><?= h($sub) ?></td>
                </tr>
                <?php foreach ($accounts as $accName => $data): ?>
                <?php if (round($data['actual'], 2) != 0): ?>
                <tr>
                    <td class="acc-item">
                        <?= $this->Html->link(h($accName), [
                            'action' => 'ledger',
                            '?' => [
                                'account_id' => $data['account_id'],
                                'start_date' => date('Y-01-01', strtotime($endDate)),
                                'end_date' => $endDate,
                                'currency' => current($this->getRequest()->getQueryParams())['currency'] ?? 'USD'
                            ]
                        ], ['target' => '_blank']) ?>
                    </td>
                    <td class="acc-amount"><?= $this->Number->format($data['actual'], ['places' => 2]) ?></td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <td><strong>Total Liabilities</strong></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['total_liabilities'], ['places' => 2]) ?></td>
            </tr>

            <!-- EQUITY -->
            <tr>
                <td colspan="2" class="acc-header" style="background:#f4fce8; padding-top:20px;">EQUITY</td>
            </tr>
            <?php foreach ($report['Equity'] as $sub => $accounts): ?>
                <tr>
                    <td colspan="2" class="acc-subcategory"><?= h($sub) ?></td>
                </tr>
                <?php foreach ($accounts as $accName => $data): ?>
                <?php if (round($data['actual'], 2) != 0): ?>
                <tr>
                    <td class="acc-item">
                        <?= $this->Html->link(h($accName), [
                            'action' => 'ledger',
                            '?' => [
                                'account_id' => $data['account_id'],
                                'start_date' => date('Y-01-01', strtotime($endDate)),
                                'end_date' => $endDate,
                                'currency' => current($this->getRequest()->getQueryParams())['currency'] ?? 'USD'
                            ]
                        ], ['target' => '_blank']) ?>
                    </td>
                    <td class="acc-amount"><?= $this->Number->format($data['actual'], ['places' => 2]) ?></td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <td class="acc-item">Retained Earnings (Net Income)</td>
                <td class="acc-amount" style="<?= $totals['retained_earnings'] < 0 ? 'color:red;' : '' ?>"><?= $this->Number->format($totals['retained_earnings'], ['places' => 2]) ?></td>
            </tr>
            <tr>
                <td><strong>Total Equity</strong></td>
                <td class="acc-subtotal"><?= $this->Number->format($totals['total_equity'], ['places' => 2]) ?></td>
            </tr>

            <!-- TOTAL LIABILITIES & EQUITY -->
            <tr style="background: #fafafa;">
                <td style="font-size: 1.1em; padding-top: 20px; padding-bottom: 20px;"><strong>TOTAL LIABILITIES & EQUITY</strong></td>
                <td class="acc-grand-total" style="padding-top: 20px; padding-bottom: 20px; <?= round($totals['total_assets'],2) !== round($totals['total_liabilities_equity'],2) ? 'color:red; background:#ffe6e6;' : 'color: #38761d;' ?>">
                    <?= $this->Number->format($totals['total_liabilities_equity'], ['places' => 2]) ?>
                </td>
            </tr>
            <?php if (round($totals['total_assets'],2) !== round($totals['total_liabilities_equity'],2)): ?>
            <tr>
                <td colspan="2" class="text-center text-danger" style="font-size: 0.9em; padding: 10px;">
                    Warning: Balance Sheet is out of balance. Check dual-entry records or uncategorized accounts. Variance: <?= $this->Number->format($totals['total_assets'] - $totals['total_liabilities_equity'], ['places' => 2]) ?>
                </td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<?= $this->element('export_csv') ?>
