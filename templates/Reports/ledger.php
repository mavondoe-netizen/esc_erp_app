<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Account $account
 * @var string $startDate
 * @var string $endDate
 * @var string $targetCurrency
 * @var float $openingBalance
 * @var array $ledgerData
 */
$this->assign('title', 'Ledger Drilldown');
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
    .acc-amount { text-align: right !important; width: 120px; }
    .acc-table th { background: #f0f0f0; border-bottom: 2px solid #ccc; }
    .text-right { text-align: right; }
</style>

<div class="reports index content">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.close()" class="button button-outline float-right" style="margin-left: 10px;">Close Window</button>
        <button onclick="window.print()" class="button float-right">Print Ledger</button>
        <h3><?= __('Ledger Drilldown: ') . h($account->name) ?></h3>
    </div>

    <div class="print-area" style="padding: 20px; background: #fff;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="margin:0;">ACCOUNT LEDGER</h2>
            <h3 style="margin:5px 0;">Account: <?= h($account->name) ?> (<?= h($account->category) ?>)</h3>
            <h4 style="margin:5px 0; color: #555;">Currency: <?= h($targetCurrency) ?> | Period: <?= h($startDate) ?> to <?= h($endDate) ?></h4>
        </div>

        <table class="acc-table no-dt">
            <thead>
                <tr>
                    <th style="width: 120px;">Date</th>
                    <th>Description</th>
                    <th class="acc-amount">Debit</th>
                    <th class="acc-amount">Credit</th>
                    <th class="acc-amount">Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background:#fafafa;">
                    <td><strong><?= h($startDate) ?></strong></td>
                    <td><strong>Opening Balance</strong></td>
                    <td class="acc-amount"></td>
                    <td class="acc-amount"></td>
                    <td class="acc-amount"><strong><?= $this->Number->currency($openingBalance, $targetCurrency) ?></strong></td>
                </tr>
                <?php foreach ($ledgerData as $row): ?>
                <tr>
                    <td><?= h($row['txn']->date->format('Y-m-d')) ?></td>
                    <td>
                        <?= h($row['txn']->description) ?>
                        <?php if ($row['txn']->reference): ?>
                            <br><small style="color:#777;">Ref: <?= h($row['txn']->reference) ?></small>
                        <?php endif; ?>
                    </td>
                    <td class="acc-amount"><?= $row['debit'] != 0 ? $this->Number->format($row['debit'], ['places' => 2]) : '-' ?></td>
                    <td class="acc-amount"><?= $row['credit'] != 0 ? $this->Number->format($row['credit'], ['places' => 2]) : '-' ?></td>
                    <td class="acc-amount"><?= $this->Number->currency($row['balance'], $targetCurrency) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr style="background:#f4fce8;">
                    <td><strong><?= h($endDate) ?></strong></td>
                    <td><strong>Closing Balance</strong></td>
                    <td class="acc-amount"></td>
                    <td class="acc-amount"></td>
                    <td class="acc-amount" style="font-weight:bold; font-size:1.1em; border-top:2px solid #ccc;">
                        <?= $this->Number->currency(empty($ledgerData) ? $openingBalance : end($ledgerData)['balance'], $targetCurrency) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
