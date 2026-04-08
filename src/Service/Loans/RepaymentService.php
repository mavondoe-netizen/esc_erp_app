<?php
declare(strict_types=1);
namespace App\Service\Loans;

use Cake\ORM\TableRegistry;

/**
 * RepaymentService — receives a payment, allocates it (penalty → interest → principal),
 * posts ledger entries, and updates the loan balance and schedule.
 */
class RepaymentService
{
    private PostingService $posting;

    public function __construct()
    {
        $this->posting = new PostingService();
    }

    /**
     * Process a loan repayment.
     *
     * @param object $loan
     * @param float  $amount         Total cash received
     * @param string $currency
     * @param int    $bankAccountId  Account receiving the funds
     * @param string $source         cash | payroll | bank_transfer
     * @param string $paymentDate    Y-m-d
     * @param int    $processedBy    User ID
     * @param string $reference
     * @return object The saved LoanRepayment entity
     */
    public function receive(
        object $loan,
        float $amount,
        string $currency,
        int $bankAccountId,
        string $source,
        string $paymentDate,
        int $processedBy,
        string $reference = ''
    ): object {
        $repaymentsTable = TableRegistry::getTableLocator()->get('LoanRepayments');
        $scheduleTable   = TableRegistry::getTableLocator()->get('LoanSchedules');
        $loansTable      = TableRegistry::getTableLocator()->get('Loans');

        $remaining = $amount;

        // --- ALLOCATION: penalty → interest → principal ---
        $penaltyPaid  = 0.0;
        $interestPaid = 0.0;
        $principalPaid = 0.0;

        // Find oldest outstanding schedule periods (FIFO)
        $overdueSchedules = $scheduleTable->find()
            ->where(['loan_id' => $loan->id, 'status IN' => ['pending', 'overdue', 'partial']])
            ->order(['due_date' => 'ASC'])
            ->all();

        $allocationDetail = [];

        foreach ($overdueSchedules as $period) {
            if ($remaining <= 0) break;

            // Penalty first
            $penaltyOwed = (float)$period->penalty_due - (float)($period->penalty_paid ?? 0);
            if ($penaltyOwed > 0 && $remaining > 0) {
                $penaltyApplied = min($penaltyOwed, $remaining);
                $penaltyPaid  += $penaltyApplied;
                $remaining    -= $penaltyApplied;
                $allocationDetail[] = ['period' => $period->period_number, 'type' => 'penalty', 'amount' => $penaltyApplied];
            }

            // Interest next
            $interestOwed = (float)$period->interest_due - (float)($period->interest_paid ?? 0);
            if ($interestOwed > 0 && $remaining > 0) {
                $interestApplied = min($interestOwed, $remaining);
                $interestPaid  += $interestApplied;
                $remaining     -= $interestApplied;
                $allocationDetail[] = ['period' => $period->period_number, 'type' => 'interest', 'amount' => $interestApplied];
            }

            // Principal last
            $principalOwed = (float)$period->principal_due - (float)($period->principal_paid ?? 0);
            if ($principalOwed > 0 && $remaining > 0) {
                $principalApplied = min($principalOwed, $remaining);
                $principalPaid  += $principalApplied;
                $remaining      -= $principalApplied;
                $allocationDetail[] = ['period' => $period->period_number, 'type' => 'principal', 'amount' => $principalApplied];
            }

            // Update schedule period
            $totalPaid = (float)$period->amount_paid + ($penaltyApplied ?? 0) + ($interestApplied ?? 0) + ($principalApplied ?? 0);
            $period->amount_paid = $totalPaid;
            $period->status = ($totalPaid >= (float)$period->total_due) ? 'paid' : 'partial';
            $scheduleTable->save($period);

            // Reset per-period temps
            $penaltyApplied  = 0;
            $interestApplied = 0;
            $principalApplied= 0;
        }

        // --- LEDGER POSTINGS ---
        $ref = $reference ?: 'RPY-' . date('YmdHis');
        if ($penaltyPaid > 0) {
            $this->posting->postRepaymentPenalty($penaltyPaid, $currency, $paymentDate, $bankAccountId, $loan->company_id, $ref);
        }
        if ($interestPaid > 0) {
            $this->posting->postRepaymentInterest($interestPaid, $currency, $paymentDate, $bankAccountId, $loan->company_id, $ref);
        }
        if ($principalPaid > 0) {
            $this->posting->postRepaymentPrincipal($principalPaid, $currency, $paymentDate, $bankAccountId, $loan->company_id, $ref);
        }

        // --- UPDATE LOAN BALANCE ---
        $loan->outstanding_balance = max(0, (float)$loan->outstanding_balance - $principalPaid);
        $loan->last_payment_date   = $paymentDate;
        if ((float)$loan->outstanding_balance <= 0) {
            $loan->status = 'closed';
        }
        $loansTable->save($loan);

        // --- SAVE REPAYMENT RECORD ---
        $repayment = $repaymentsTable->newEntity([
            'loan_id'        => $loan->id,
            'client_id'      => $loan->client_id,
            'amount'         => $amount,
            'currency'       => $currency,
            'source'         => $source,
            'payment_date'   => $paymentDate,
            'penalty_paid'   => round($penaltyPaid, 2),
            'interest_paid'  => round($interestPaid, 2),
            'principal_paid' => round($principalPaid, 2),
            'reference'      => $ref,
            'account_id'     => $bankAccountId,
            'processed_by'   => $processedBy,
            'allocation_json'=> json_encode($allocationDetail),
        ]);
        $repaymentsTable->save($repayment);

        return $repayment;
    }
}
