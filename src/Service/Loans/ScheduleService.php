<?php
declare(strict_types=1);
namespace App\Service\Loans;

use Cake\ORM\TableRegistry;

/**
 * ScheduleService — generates amortisation schedules.
 * Supports: flat-rate and reducing-balance, multi-currency.
 */
class ScheduleService
{
    /**
     * Generate and save a full repayment schedule for a loan.
     *
     * @param object $loan  Loan entity (principal, interest_rate, term, interest_method, start_date, currency)
     * @return array The generated schedule rows
     */
    public function generate(object $loan): array
    {
        $scheduleTable = TableRegistry::getTableLocator()->get('LoanSchedules');

        // Delete any existing schedule for this loan
        $scheduleTable->deleteAll(['loan_id' => $loan->id]);

        $principal     = (float)$loan->principal;
        $annualRate    = (float)$loan->interest_rate;          // stored as percentage e.g. 18.0
        $monthlyRate   = $annualRate / 100 / 12;
        $term          = (int)$loan->term;
        $method        = $loan->interest_method ?? 'reducing';
        $currency      = $loan->currency ?? 'USD';
        $startDate     = $loan->start_date instanceof \DateTimeInterface
                         ? $loan->start_date
                         : new \DateTime($loan->start_date);

        $schedule = [];
        $balance  = $principal;

        if ($method === 'flat') {
            // Flat-rate: interest computed on original principal throughout
            $totalInterest     = $principal * ($annualRate / 100) * ($term / 12);
            $totalRepayable    = $principal + $totalInterest;
            $installment       = round($totalRepayable / $term, 2);
            $principalPerPeriod = round($principal / $term, 2);
            $interestPerPeriod  = round($totalInterest / $term, 2);

            for ($i = 1; $i <= $term; $i++) {
                $dueDate = (clone $startDate)->modify("+{$i} months");
                $isLast  = ($i === $term);

                $principalDue = $isLast ? $balance : $principalPerPeriod;
                $interestDue  = $interestPerPeriod;
                $totalDue     = $principalDue + $interestDue;
                $balance      = max(0, $balance - $principalDue);

                $row = $scheduleTable->newEntity([
                    'loan_id'       => $loan->id,
                    'period_number' => $i,
                    'due_date'      => $dueDate->format('Y-m-d'),
                    'principal_due' => round($principalDue, 2),
                    'interest_due'  => round($interestDue, 2),
                    'penalty_due'   => 0,
                    'total_due'     => round($totalDue, 2),
                    'amount_paid'   => 0,
                    'balance'       => round($balance, 2),
                    'currency'      => $currency,
                    'status'        => 'pending',
                ]);
                $scheduleTable->save($row);
                $schedule[] = $row;
            }
        } else {
            // Reducing-balance (PMT formula)
            if ($monthlyRate > 0) {
                $pmt = $principal * ($monthlyRate * pow(1 + $monthlyRate, $term))
                       / (pow(1 + $monthlyRate, $term) - 1);
            } else {
                $pmt = $principal / $term;
            }

            for ($i = 1; $i <= $term; $i++) {
                $dueDate     = (clone $startDate)->modify("+{$i} months");
                $interestDue = round($balance * $monthlyRate, 2);
                $isLast      = ($i === $term);
                $principalDue = $isLast ? $balance : round($pmt - $interestDue, 2);
                $principalDue = min($principalDue, $balance);  // never exceed balance
                $totalDue     = $principalDue + $interestDue;
                $balance      = max(0, round($balance - $principalDue, 2));

                $row = $scheduleTable->newEntity([
                    'loan_id'       => $loan->id,
                    'period_number' => $i,
                    'due_date'      => $dueDate->format('Y-m-d'),
                    'principal_due' => $principalDue,
                    'interest_due'  => $interestDue,
                    'penalty_due'   => 0,
                    'total_due'     => round($totalDue, 2),
                    'amount_paid'   => 0,
                    'balance'       => $balance,
                    'currency'      => $currency,
                    'status'        => 'pending',
                ]);
                $scheduleTable->save($row);
                $schedule[] = $row;
            }
        }

        return $schedule;
    }

    /**
     * Re-generate a schedule after restructuring (uses new terms on existing loan).
     */
    public function regenerate(object $loan): array
    {
        return $this->generate($loan);
    }
}
