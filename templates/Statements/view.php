<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $transactions
 * @var string $entityName
 * @var \App\Model\Entity\Company $company
 * @var \Cake\I18n\DateTime $startDate
 * @var \Cake\I18n\DateTime $endDate
 * @var float $openingBalance
 * @var string $type
 */
$this->assign('title', 'Statement of Account - ' . h($entityName));
?>
<div class="financial-statement">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 30px; margin-bottom: 40px;">
        <div>
            <?php if ($company->logo): ?>
                <img src="<?= $company->logo ?>" style="max-height: 70px; margin-bottom: 15px;">
            <?php else: ?>
                <h2 style="margin: 0; color: #1e293b; font-weight: 800;"><?= h($company->name) ?></h2>
            <?php endif; ?>
            <p style="color: #64748b; font-size: 0.85rem; margin: 0; max-width: 300px;"><?= h($company->address) ?></p>
        </div>
        <div style="text-align: right;">
            <h1 style="margin: 0; font-size: 1.75rem; color: #0f172a; text-transform: uppercase; font-weight: 900; letter-spacing: 1px;">Statement of Account</h1>
            <p style="color: #64748b; margin: 5px 0 0 0;">PERIOD: <span style="font-weight: 700; color: #1e293b;"><?= $startDate->format('d M Y') ?> — <?= $endDate->format('d M Y') ?></span></p>
        </div>
    </div>

    <!-- Entity & Summary Info -->
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px; margin-bottom: 50px;">
        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Statement For:</label>
            <h4 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #1e293b;"><?= h($entityName) ?></h4>
            <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Entity Type: <?= ucfirst($type) ?></p>
        </div>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span style="color: #64748b; font-size: 0.85rem;">Opening Balance:</span>
                <span style="font-weight: 700; color: #1e293b;">$<?= number_format($openingBalance, 2) ?></span>
            </div>
            <?php
                $totalDr = 0;
                $totalCr = 0;
                foreach($transactions as $t) {
                    if ($t->type === 'Debit') $totalDr += $t->amount;
                    else $totalCr += $t->amount;
                }
                $closingBalance = $openingBalance + $totalDr - $totalCr;
            ?>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span style="color: #64748b; font-size: 0.85rem;">Total Debits:</span>
                <span style="font-weight: 700; color: #1e293b;">$<?= number_format($totalDr, 2) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span style="color: #64748b; font-size: 0.85rem;">Total Credits:</span>
                <span style="font-weight: 700; color: #1e293b;">$<?= number_format($totalCr, 2) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; border-top: 2px solid #e2e8f0; padding-top: 15px;">
                <span style="font-weight: 800; color: #0f172a; text-transform: uppercase; font-size: 0.85rem;">Closing Balance:</span>
                <span style="font-weight: 900; color: #4f46e5; font-size: 1.1rem;">$<?= number_format($closingBalance, 2) ?></span>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">
        <thead>
            <tr style="background: #1e293b; color: white; text-align: left;">
                <th style="padding: 12px 15px; font-size: 0.8rem; text-transform: uppercase;">Date</th>
                <th style="padding: 12px 15px; font-size: 0.8rem; text-transform: uppercase;">Description</th>
                <th style="padding: 12px 15px; font-size: 0.8rem; text-transform: uppercase; text-align: right;">Debit</th>
                <th style="padding: 12px 15px; font-size: 0.8rem; text-transform: uppercase; text-align: right;">Credit</th>
                <th style="padding: 12px 15px; font-size: 0.8rem; text-transform: uppercase; text-align: right;">Running Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background: #f1f5f9; border-bottom: 1px solid #e2e8f0;">
                <td style="padding: 12px 15px; color: #64748b; font-size: 0.9rem;"><?= $startDate->format('d M Y') ?></td>
                <td style="padding: 12px 15px; font-weight: 700; color: #1e293b;">OPENING BALANCE</td>
                <td style="padding: 12px 15px; text-align: right; color: #94a3b8;">—</td>
                <td style="padding: 12px 15px; text-align: right; color: #94a3b8;">—</td>
                <td style="padding: 12px 15px; text-align: right; font-weight: 800; color: #0f172a;">$<?= number_format($openingBalance, 2) ?></td>
            </tr>
            <?php 
            $runningBalance = $openingBalance;
            foreach ($transactions as $t): 
                if ($t->type === 'Debit') $runningBalance += $t->amount;
                else $runningBalance -= $t->amount;
            ?>
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 12px 15px; color: #64748b; font-size: 0.9rem;"><?= $t->date->format('d M Y') ?></td>
                <td style="padding: 12px 15px; color: #334155; font-size: 0.9rem;"><?= h($t->description) ?></td>
                <td style="padding: 12px 15px; text-align: right; color: #1e293b; font-weight: 600;">
                    <?= $t->type === 'Debit' ? '$' . number_format($t->amount, 2) : '<span style="color:#cbd5e1;">—</span>' ?>
                </td>
                <td style="padding: 12px 15px; text-align: right; color: #16a34a; font-weight: 600;">
                    <?= $t->type === 'Credit' ? '$' . number_format($t->amount, 2) : '<span style="color:#cbd5e1;">—</span>' ?>
                </td>
                <td style="padding: 12px 15px; text-align: right; font-weight: 700; color: #0f172a;">
                    $<?= number_format($runningBalance, 2) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background: #f8fafc; border-top: 2px solid #e2e8f0;">
                <td colspan="2" style="padding: 15px; font-weight: 800; text-align: right; text-transform: uppercase; color: #64748b; font-size: 0.8rem;">Closing Balance as of <?= $endDate->format('d M Y') ?></td>
                <td colspan="3" style="padding: 15px; text-align: right; font-weight: 900; color: #4f46e5; font-size: 1.25rem;">$<?= number_format($closingBalance, 2) ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <div style="margin-top: 60px; border-top: 1px dashed #cbd5e1; padding-top: 20px; color: #94a3b8; font-size: 0.75rem; text-align: center;">
        This is a computer-generated statement and does not require a physical signature. <br>
        For any discrepancies, please contact <?= h($company->name) ?> Finance Department within 7 days.
    </div>
</div>
