<?php
declare(strict_types=1);
namespace App\Service\Loans;

use Cake\ORM\TableRegistry;

/**
 * DisbursementService — records disbursement and activates the loan.
 */
class DisbursementService
{
    private PostingService $posting;
    private ScheduleService $schedule;

    public function __construct()
    {
        $this->posting  = new PostingService();
        $this->schedule = new ScheduleService();
    }

    /**
     * Disburse a loan:
     * 1. Saves disbursement record
     * 2. Posts Dr Loan Receivable / Cr Bank
     * 3. Generates repayment schedule
     * 4. Activates loan status
     */
    public function disburse(object $loan, int $bankAccountId, string $method, string $reference, int $disbursedBy): object
    {
        if ($loan->status !== 'pending_disbursement') {
            throw new \RuntimeException("Loan is not in pending_disbursement status.");
        }

        $loansTable         = TableRegistry::getTableLocator()->get('Loans');
        $disbursementsTable = TableRegistry::getTableLocator()->get('LoanDisbursements');

        // 1. Ledger posting
        $client = TableRegistry::getTableLocator()->get('LoanClients')->get($loan->client_id);
        $this->posting->postDisbursement(
            (float)$loan->principal,
            $loan->currency,
            date('Y-m-d'),
            $bankAccountId,
            $loan->company_id,
            $client->name
        );

        // 2. Save disbursement record
        $disbursementsTable->save($disbursementsTable->newEntity([
            'loan_id'        => $loan->id,
            'amount'         => $loan->principal,
            'currency'       => $loan->currency,
            'method'         => $method,
            'bank_reference' => $reference,
            'account_id'     => $bankAccountId,
            'disbursed_by'   => $disbursedBy,
            'disbursed_at'   => date('Y-m-d H:i:s'),
        ]));

        // 3. Activate the loan
        $loan->status       = 'active';
        $loan->disbursed_at = date('Y-m-d H:i:s');
        $loan->start_date   = $loan->start_date ?? date('Y-m-d');
        $loansTable->save($loan);

        // 4. Generate schedule
        $this->schedule->generate($loan);

        return $loan;
    }
}
