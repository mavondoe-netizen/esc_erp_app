<?php
/**
 * @var \App\View\AppView $this
 * @var array $bill
 */
?>
<div style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2c3e50;">Bill Notification</h2>
    <p>A new bill has been recorded in the system:</p>
    
    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Bill Number:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= h($bill['number'] ?? $bill['id']) ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Amount:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= number_format((float)($bill['total'] ?? 0), 2) ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Due Date:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= h($bill['due_date'] ?? 'N/A') ?></td>
        </tr>
    </table>

    <p>This notification is for your records.</p>
    
    <p style="margin-top: 30px;">
        Best regards,<br>
        <strong>ESC ERP System</strong>
    </p>
</div>
