<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $entity
 * @var iterable $transactions
 * @var float $openingBalance
 * @var float $closingBalance
 * @var \Cake\I18n\DateTime $startDate
 * @var \Cake\I18n\DateTime $endDate
 */
?>
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;">
    <h2 style="color: #4f46e5;">Statement of Account</h2>
    <p>Dear <?= h($entity->name ?? 'Valued Customer') ?>,</p>
    
    <p>Please find below the summary of your account statement for the period <strong><?= $startDate->format('d M Y') ?></strong> to <strong><?= $endDate->format('d M Y') ?></strong>.</p>

    <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #e2e8f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px 0; color: #64748b;">Opening Balance:</td>
                <td style="padding: 5px 0; text-align: right; font-weight: bold;">$<?= number_format($openingBalance, 2) ?></td>
            </tr>
            <tr>
                <td style="padding: 5px 0; color: #64748b;">Period Activity:</td>
                <td style="padding: 5px 0; text-align: right; font-weight: bold;">
                    <?php 
                        $activity = $closingBalance - $openingBalance;
                        echo ($activity >= 0 ? '+' : '') . '$' . number_format($activity, 2);
                    ?>
                </td>
            </tr>
            <tr style="border-top: 1px solid #cbd5e1;">
                <td style="padding: 10px 0; color: #1e293b; font-weight: bold;">Closing Balance:</td>
                <td style="padding: 10px 0; text-align: right; font-weight: 900; color: #4f46e5; font-size: 1.2rem;">$<?= number_format($closingBalance, 2) ?></td>
            </tr>
        </table>
    </div>

    <p>For a detailed breakdown of transactions, please log in to your portal or contact our finance department.</p>

    <div style="margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px; font-size: 0.85rem; color: #64748b;">
        Regards,<br>
        <strong>Finance Team</strong>
    </div>
</div>
