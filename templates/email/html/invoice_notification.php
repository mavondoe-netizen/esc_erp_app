<?php
/**
 * @var \App\View\AppView $this
 * @var array $invoice
 */
?>
<div style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2c3e50;">Hello,</h2>
    <p>Please find the details of your invoice below:</p>
    
    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Invoice Number:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= h($invoice['number'] ?? $invoice['id']) ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Amount Due:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= number_format((float)($invoice['total'] ?? 0), 2) ?></td>
        </tr>
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #eee; font-weight: bold;">Due Date:</td>
            <td style="padding: 8px; border-bottom: 1px solid #eee;"><?= h($invoice['due_date'] ?? 'N/A') ?></td>
        </tr>
    </table>

    <p>You can view the full details by logging into the portal.</p>
    
    <p style="margin-top: 30px;">
        Best regards,<br>
        <strong>ESC ERP System</strong>
    </p>
</div>
