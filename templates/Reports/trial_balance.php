<?php
/**
 * @var \App\View\AppView $this
 * @var array $trialBalance
 * @var array $totals
 * @var string $startDate
 * @var string $endDate
 * @var string $currency
 */
$this->assign('title', 'Trial Balance');
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
    .acc-table th, .acc-table td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; }
    .acc-table thead th { background: #f4f7f6; color: #444; font-weight: bold; border-bottom: 2px solid #dfe6e9; }
    .text-right { text-align: right !important; }
    .acc-grand-total { font-weight: bold; font-size: 1.1em; background: #fcfcfc; border-top: 2px solid #333; border-bottom: 4px double #333; }
    .currency-tag { font-size: 0.8em; color: #777; margin-left: 5px; }
</style>

<div class="reports index content">
    <div class="no-print">
        <div class="row">
            <div class="column">
                <h3><?= __('Trial Balance') ?></h3>
            </div>
            <div class="column text-right" style="padding-top: 10px;">
                <button type="button" onclick="window.print()" class="button button-outline">Print Report</button>
            </div>
        </div>
        
        <div class="filters">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row align-items-end']) ?>
            <div class="column">
                <?= $this->Form->control('start_date', [
                    'type' => 'date',
                    'value' => $startDate,
                    'label' => 'Start Date'
                ]) ?>
            </div>
            <div class="column">
                <?= $this->Form->control('end_date', [
                    'type' => 'date',
                    'value' => $endDate,
                    'label' => 'End Date'
                ]) ?>
            </div>
            <div class="column">
                <?= $this->Form->control('currency', [
                    'options' => ['USD' => 'USD', 'ZWG' => 'ZWG'],
                    'value' => $currency,
                    'label' => 'Currency'
                ]) ?>
            </div>
            <div class="column">
                <?= $this->Form->button(__('Generate'), ['class' => 'button']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <div class="print-area">
        <div style="text-align: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
            <h2 style="margin:0; text-transform: uppercase;"><?= h(\Cake\Core\Configure::read('Tenant.company_name')) ?></h2>
            <h3 style="margin:5px 0; color: #333;">TRIAL BALANCE</h3>
            <p style="margin:0; color: #666;">For the period: <?= h($startDate) ?> to <?= h($endDate) ?></p>
            <p style="margin:5px 0 0; font-weight: bold;">Currency: <?= h($currency) ?></p>
        </div>

        <table class="acc-table no-dt">
            <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Type</th>
                    <th class="text-right">Debit</th>
                    <th class="text-right">Credit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trialBalance as $row): ?>
                <tr>
                    <td>
                        <?= $this->Html->link(h($row['name']), [
                            'action' => 'ledger', 
                            '?' => [
                                'account_id' => $row['account_id'],
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                                'currency' => $currency
                            ]
                        ], ['style' => 'color: #2980b9; text-decoration: none;']) ?>
                    </td>
                    <td><small class="text-muted"><?= h($row['type']) ?></small></td>
                    <td class="text-right">
                        <?= $row['debit'] > 0 ? $this->Number->format($row['debit'] ?? 0.0, ['places' => 2]) : '—' ?>
                    </td>
                    <td class="text-right">
                        <?= $row['credit'] > 0 ? $this->Number->format($row['credit'] ?? 0.0, ['places' => 2]) : '—' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="acc-grand-total">
                    <td colspan="2"><strong>TOTALS</strong></td>
                    <td class="text-right"><strong><?= $this->Number->format($totals['debit'] ?? 0.0, ['places' => 2]) ?></strong></td>
                    <td class="text-right"><strong><?= $this->Number->format($totals['credit'] ?? 0.0, ['places' => 2]) ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <?php if (abs($totals['debit'] - $totals['credit']) > 0.01): ?>
            <div style="margin-top: 20px; padding: 15px; background: #fff5f5; border: 1px solid #feb2b2; border-radius: 5px; color: #c53030; font-weight: bold; text-align: center;">
                WARNING: The Trial Balance is NOT balanced. Difference: <?= $this->Number->format(abs(($totals['debit'] ?? 0) - ($totals['credit'] ?? 0)), ['places' => 2]) ?>
            </div>
        <?php else: ?>
            <div style="margin-top: 20px; text-align: center; color: #38a169; font-size: 0.9em; font-style: italic;">
                The ledger is in balance.
            </div>
        <?php endif; ?>
    </div>
</div>
