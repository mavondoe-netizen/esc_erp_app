<?php
declare(strict_types=1);
namespace App\Service\Loans;

use Cake\ORM\TableRegistry;

/**
 * LoanService — activates an approved application as a live loan account.
 */
class LoanService
{
    private ScheduleService $scheduleService;

    public function __construct()
    {
        $this->scheduleService = new ScheduleService();
    }

    /**
     * Create a Loan entity from an approved LoanApplication.
     * Generates account number and saves the loan record.
     *
     * @throws \RuntimeException if application is not in approved status
     */
    public function createFromApplication(object $application): object
    {
        if ($application->status !== 'approved') {
            throw new \RuntimeException("Only approved applications can be converted to loans.");
        }

        $loansTable = TableRegistry::getTableLocator()->get('Loans');

        $loan = $loansTable->newEntity([
            'company_id'          => $application->company_id,
            'client_id'           => $application->client_id,
            'loan_application_id' => $application->id,
            'loan_product_id'     => $application->loan_product_id,
            'loan_account_no'     => $this->generateAccountNumber($application->company_id),
            'principal'           => $application->amount_requested,
            'outstanding_balance' => $application->amount_requested,
            'interest_rate'       => $this->getProductRate($application->loan_product_id),
            'interest_method'     => $this->getProductMethod($application->loan_product_id),
            'repayment_frequency' => $this->getProductFrequency($application->loan_product_id),
            'term'                => $application->term,
            'currency'            => $application->currency,
            'start_date'          => date('Y-m-d'),
            'maturity_date'       => date('Y-m-d', strtotime("+{$application->term} months")),
            'status'              => 'pending_disbursement',
        ]);

        $loansTable->saveOrFail($loan);
        return $loan;
    }

    /**
     * Generate a unique loan account number: LN-{companyId}-{year}-{seq}
     */
    public function generateAccountNumber(int $companyId): string
    {
        $loansTable = TableRegistry::getTableLocator()->get('Loans');
        $count = $loansTable->find()->where(['company_id' => $companyId])->count();
        return sprintf('LN-%d-%s-%04d', $companyId, date('Y'), $count + 1);
    }

    private function getProductRate(int $productId): float
    {
        $product = TableRegistry::getTableLocator()->get('LoanProducts')->get($productId);
        return (float)$product->interest_rate;
    }

    private function getProductMethod(int $productId): string
    {
        $product = TableRegistry::getTableLocator()->get('LoanProducts')->get($productId);
        return $product->interest_method ?? 'reducing';
    }

    private function getProductFrequency(int $productId): string
    {
        $product = TableRegistry::getTableLocator()->get('LoanProducts')->get($productId);
        return $product->repayment_frequency ?? 'monthly';
    }
}
