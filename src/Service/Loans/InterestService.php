<?php
declare(strict_types=1);
namespace App\Service\Loans;

use Cake\ORM\TableRegistry;

/**
 * InterestService — monthly interest accrual for all active loans.
 * Can also compute the payoff amount for early settlement.
 */
class InterestService
{
    private PostingService $posting;

    public function __construct()
    {
        $this->posting = new PostingService();
    }

    /**
     * Accrue monthly interest for all active loans in the system.
     * Called by a scheduled job or manually triggered.
     *
     * @return array Summary of accruals
     */
    public function accrueMonthly(): array
    {
        $loansTable    = TableRegistry::getTableLocator()->get('Loans');
        $scheduleTable = TableRegistry::getTableLocator()->get('LoanSchedules');

        $activeLoans = $loansTable->find()
            ->where(['status' => 'active'])
            ->all();

        $results = [];

        foreach ($activeLoans as $loan) {
            $monthlyRate = (float)$loan->interest_rate / 100 / 12;
            $interest    = round((float)$loan->outstanding_balance * $monthlyRate, 4);

            if ($interest <= 0) continue;

            // Find the next pending schedule period (to attach accrual to)
            $nextPeriod = $scheduleTable->find()
                ->where(['loan_id' => $loan->id, 'status IN' => ['pending', 'partial']])
                ->order(['due_date' => 'ASC'])
                ->first();

            // Post to ledger
            try {
                $this->posting->postInterestAccrual(
                    $interest,
                    $loan->currency,
                    date('Y-m-d'),
                    $loan->company_id,
                    $loan->loan_account_no
                );
                $results[] = ['loan_id' => $loan->id, 'accrued' => $interest, 'currency' => $loan->currency];
            } catch (\Exception $e) {
                $results[] = ['loan_id' => $loan->id, 'error' => $e->getMessage()];
            }
        }

        return $results;
    }

    /**
     * Calculate payoff amount today (outstanding balance + accrued interest to date).
     */
    public function getPayoffAmount(object $loan): float
    {
        $monthlyRate  = (float)$loan->interest_rate / 100 / 12;
        $daysInMonth  = date('t');
        $dayOfMonth   = (int)date('j');
        $dailyFraction = $dayOfMonth / $daysInMonth;
        $accruedInterest = (float)$loan->outstanding_balance * $monthlyRate * $dailyFraction;
        return round((float)$loan->outstanding_balance + $accruedInterest, 2);
    }
}
