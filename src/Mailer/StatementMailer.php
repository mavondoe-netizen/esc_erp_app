<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

class StatementMailer extends Mailer
{
    public function sendStatement($entity, $transactions, $openingBalance, $closingBalance, $startDate, $endDate, $recipientEmail)
    {
        return $this
            ->setTo($recipientEmail)
            ->setSubject(sprintf('Statement of Account: %s to %s', $startDate->format('d M Y'), $endDate->format('d M Y')))
            ->setViewVars(compact('entity', 'transactions', 'openingBalance', 'closingBalance', 'startDate', 'endDate'))
            ->viewBuilder()
                ->setTemplate('statement')
                ->setLayout('default');
    }
}
