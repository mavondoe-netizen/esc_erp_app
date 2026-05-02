Hello,

Please find the details of your invoice below:

Invoice Number: <?= h($invoice['number'] ?? $invoice['id']) ?>
Amount Due: <?= number_format((float)($invoice['total'] ?? 0), 2) ?>
Due Date: <?= h($invoice['due_date'] ?? 'N/A') ?>

You can view the full details by logging into the portal.

Best regards,
ESC ERP System
