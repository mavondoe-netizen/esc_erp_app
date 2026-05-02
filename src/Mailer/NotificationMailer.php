<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * Notification Mailer
 */
class NotificationMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static string $name = 'Notification';

    /**
     * Send an invoice notification.
     *
     * @param array $invoice The invoice data or entity.
     * @param string $recipientEmail The recipient's email address.
     * @return $this
     */
    public function invoice(array $invoice, string $recipientEmail)
    {
        return $this
            ->setTo($recipientEmail)
            ->setSubject(sprintf('Invoice #%s from ESC ERP', $invoice['number'] ?? $invoice['id']))
            ->setViewVars(['invoice' => $invoice])
            ->viewBuilder()
                ->setTemplate('invoice_notification');
    }

    /**
     * Send a deal notification.
     */
    public function deal(array $deal, string $recipientEmail)
    {
        return $this
            ->setTo($recipientEmail)
            ->setSubject(sprintf('Deal Update: %s', $deal['name']))
            ->setViewVars(['deal' => $deal])
            ->viewBuilder()
                ->setTemplate('deal_notification');
    }

    /**
     * Send a bill notification.
     */
    public function bill(array $bill, string $recipientEmail)
    {
        return $this
            ->setTo($recipientEmail)
            ->setSubject(sprintf('Bill Received: #%s', $bill['number'] ?? $bill['id']))
            ->setViewVars(['bill' => $bill])
            ->viewBuilder()
                ->setTemplate('bill_notification');
    }

    /**
     * Send a payment notification.
     */
    public function payment(array $payment, string $recipientEmail)
    {
        return $this
            ->setTo($recipientEmail)
            ->setSubject(sprintf('Payment Confirmation: #%s', $payment['id']))
            ->setViewVars(['payment' => $payment])
            ->viewBuilder()
                ->setTemplate('payment_notification');
    }
}
