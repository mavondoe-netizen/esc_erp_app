<?php
/**
 * @var \App\View\AppView $this
 * @var array $deal
 */
?>
<div style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2c3e50;">Deal Notification</h2>
    <p>A deal has been updated or created in the system:</p>
    
    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Deal Name:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= h($deal['name']) ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Status:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= h($deal['status'] ?? 'Draft') ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Value:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= number_format((float)($deal['value'] ?? 0), 2) ?></td>
        </tr>
    </table>

    <p>Please log in to the ERP to view the full details.</p>
    
    <p style="margin-top: 30px;">
        Best regards,<br>
        <strong>ESC ERP System</strong>
    </p>
</div>
