<?php
declare(strict_types=1);
namespace App\Service\Loans;

use Cake\ORM\TableRegistry;
use Cake\Mailer\Mailer;

/**
 * DelinquencyService — scans active loans and flags overdue schedules.
 * Categories: 0–30 = watch, 31–60 = at_risk, 61–90 = delinquent, 90+ = default
 * Sends email notifications when loans cross thresholds.
 */
class DelinquencyService
{
    public function updateStatuses(): array
    {
        $loansTable      = TableRegistry::getTableLocator()->get('Loans');
        $scheduleTable   = TableRegistry::getTableLocator()->get('LoanSchedules');
        $flagsTable      = TableRegistry::getTableLocator()->get('DelinquencyFlags');
        $clientsTable    = TableRegistry::getTableLocator()->get('LoanClients');

        $activeLoans = $loansTable->find()->where(['status IN' => ['active', 'delinquent']])->all();
        $today       = new \DateTime();
        $results     = [];

        foreach ($activeLoans as $loan) {
            // Find oldest overdue period
            $overduePeriod = $scheduleTable->find()
                ->where([
                    'loan_id'    => $loan->id,
                    'status IN'  => ['pending', 'partial'],
                    'due_date <' => $today->format('Y-m-d'),
                ])
                ->order(['due_date' => 'ASC'])
                ->first();

            if (!$overduePeriod) {
                // Resolve any existing flag
                $flagsTable->updateAll(['resolved_at' => date('Y-m-d H:i:s')], [
                    'loan_id'       => $loan->id,
                    'resolved_at IS' => null,
                ]);
                // Restore loan status if it was marked delinquent
                if ($loan->status === 'delinquent') {
                    $loan->status = 'active';
                    $loansTable->save($loan);
                }
                continue;
            }

            $dueDate     = $overduePeriod->due_date instanceof \DateTimeInterface
                           ? $overduePeriod->due_date
                           : new \DateTime($overduePeriod->due_date);
            $daysOverdue = (int)$today->diff($dueDate)->days;
            $amountOverdue = (float)$overduePeriod->total_due - (float)$overduePeriod->amount_paid;

            $category = match(true) {
                $daysOverdue <= 30  => 'watch',
                $daysOverdue <= 60  => 'at_risk',
                $daysOverdue <= 90  => 'delinquent',
                default             => 'default',
            };

            // Upsert flag
            $existing = $flagsTable->find()
                ->where(['loan_id' => $loan->id, 'resolved_at IS' => null])
                ->first();

            $isNew = false;
            if ($existing) {
                $existing->days_overdue   = $daysOverdue;
                $existing->amount_overdue = $amountOverdue;
                $existing->category       = $category;
                $flagsTable->save($existing);
                $flag = $existing;
            } else {
                $flag = $flagsTable->save($flagsTable->newEntity([
                    'loan_id'       => $loan->id,
                    'days_overdue'  => $daysOverdue,
                    'amount_overdue'=> $amountOverdue,
                    'currency'      => $loan->currency,
                    'category'      => $category,
                    'flagged_at'    => date('Y-m-d H:i:s'),
                ]));
                $isNew = true;
            }

            // Update loan status
            if (in_array($category, ['delinquent', 'default'])) {
                $loan->status = 'delinquent';
                $loansTable->save($loan);
            }

            // Email notification for new flags or category escalation
            if ($isNew || ($existing && $existing->isDirty('category'))) {
                $this->sendDelinquencyEmail($loan, $flag, $clientsTable);
            }

            $results[] = ['loan_id' => $loan->id, 'days' => $daysOverdue, 'category' => $category];
        }

        return $results;
    }

    private function sendDelinquencyEmail(object $loan, object $flag, object $clientsTable): void
    {
        try {
            $client = $clientsTable->get($loan->client_id);
            if (empty($client->contact_email)) return;

            $mailer = new Mailer('default');
            $mailer->setTo($client->contact_email)
                   ->setSubject('Loan Overdue Notice — Account ' . $loan->loan_account_no)
                   ->setEmailFormat('html')
                   ->deliver(sprintf(
                       '<p>Dear %s,</p>
                       <p>Your loan account <strong>%s</strong> has an overdue balance of <strong>%s %.2f</strong> 
                       which is <strong>%d days</strong> past due.</p>
                       <p>Category: <strong>%s</strong></p>
                       <p>Please make payment immediately to avoid further penalties.</p>',
                       h($client->name),
                       h($loan->loan_account_no),
                       h($loan->currency),
                       $flag->amount_overdue,
                       $flag->days_overdue,
                       strtoupper($flag->category)
                   ));
        } catch (\Exception $e) {
            // Log but don't fail the delinquency update
        }
    }
}
