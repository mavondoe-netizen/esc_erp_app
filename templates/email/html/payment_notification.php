<?php
/**
 * @var \App\View\AppView $this
 * @var array $payment
 */
?>
<div style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2c3e50;">Payment Confirmation</h2>
    <p>A payment has been processed in the system:</p>
    
    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Payment ID:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;">#<?= h($payment['id']) ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Amount Paid:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= number_format((float)($payment['amount'] ?? 0), 2) ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Date:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= h($payment['date'] ?? date('Y-m-d')) ?></td>
        </tr>
    </table>

    <p>Thank you for using our ERP system.</p>
    
    <p style="margin-top: 30px;">
        Best regards,<br>
        <strong>ESC ERP System</strong>
    </p>
</div>
