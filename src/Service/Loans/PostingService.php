<?php
declare(strict_types=1);
namespace App\Service\Loans;

use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * PostingService — wraps the existing Transactions ledger.
 * All LMS ledger entries are posted as balanced debit/credit pairs
 * sharing a transaction_group UUID for cascade-delete integrity.
 */
class PostingService
{
    private array $accountCache = [];

    /**
     * Find an account by name pattern within the tenant scope.
     */
    public function findAccount(string $namePattern, int $companyId): ?object
    {
        $key = $namePattern . '_' . $companyId;
        if (isset($this->accountCache[$key])) {
            return $this->accountCache[$key];
        }
        $acct = TableRegistry::getTableLocator()->get('Accounts')
            ->find()
            ->where([
                'name LIKE'  => '%' . $namePattern . '%',
                'OR' => [
                    ['company_id' => $companyId],
                    ['company_id IS' => null],
                ],
            ])
            ->first();
        $this->accountCache[$key] = $acct;
        return $acct;
    }

    /**
     * Core post: two symmetric transactions (Debit + Credit).
     *
     * @param int    $debitAccountId  The account to debit
     * @param int    $creditAccountId The account to credit
     * @param float  $amount
     * @param string $currency
     * @param string $date            Y-m-d
     * @param string $description
     * @param int    $companyId
     * @param array  $extra           Extra fields e.g. tenant_id, building_id
     * @return string  The transaction_group UUID for audit trail
     */
    public function post(
        int $debitAccountId,
        int $creditAccountId,
        float $amount,
        string $currency,
        string $date,
        string $description,
        int $companyId,
        array $extra = []
    ): string {
        $txTable = TableRegistry::getTableLocator()->get('Transactions');
        $group   = Text::uuid();

        $base = array_merge([
            'date'              => $date,
            'description'       => $description,
            'amount'            => $amount,
            'zwg'               => $amount,
            'currency'          => $currency,
            'company_id'        => $companyId,
            'transaction_group' => $group,
        ], $extra);

        // Debit (type 2)
        $txTable->save($txTable->newEntity(array_merge($base, [
            'account_id' => $debitAccountId,
            'type'       => '2',
        ])));

        // Credit (type 1)
        $txTable->save($txTable->newEntity(array_merge($base, [
            'account_id' => $creditAccountId,
            'type'       => '1',
        ])));

        return $group;
    }

    /**
     * Disburse: Dr Loan Receivable / Cr Bank
     */
    public function postDisbursement(float $amount, string $currency, string $date, int $bankAccountId, int $companyId, string $clientName): string
    {
        $loanReceivable = $this->findAccount('Loan Receivable', $companyId);
        if (!$loanReceivable) {
            throw new \RuntimeException("Account 'Loan Receivable' not found for company {$companyId}");
        }
        return $this->post($loanReceivable->id, $bankAccountId, $amount, $currency, $date, "Loan Disbursement – {$clientName}", $companyId);
    }

    /**
     * Repayment — principal portion: Dr Bank / Cr Loan Receivable
     */
    public function postRepaymentPrincipal(float $amount, string $currency, string $date, int $bankAccountId, int $companyId, string $ref): string
    {
        $loanReceivable = $this->findAccount('Loan Receivable', $companyId);
        if (!$loanReceivable) throw new \RuntimeException("Account 'Loan Receivable' not found");
        return $this->post($bankAccountId, $loanReceivable->id, $amount, $currency, $date, "Repayment Principal – {$ref}", $companyId);
    }

    /**
     * Repayment — interest portion: Dr Bank / Cr Interest Income
     */
    public function postRepaymentInterest(float $amount, string $currency, string $date, int $bankAccountId, int $companyId, string $ref): string
    {
        $interestIncome = $this->findAccount('Interest Income', $companyId);
        if (!$interestIncome) throw new \RuntimeException("Account 'Interest Income' not found");
        return $this->post($bankAccountId, $interestIncome->id, $amount, $currency, $date, "Repayment Interest – {$ref}", $companyId);
    }

    /**
     * Repayment — penalty portion: Dr Bank / Cr Penalty Income
     */
    public function postRepaymentPenalty(float $amount, string $currency, string $date, int $bankAccountId, int $companyId, string $ref): string
    {
        $penaltyIncome = $this->findAccount('Penalty Income', $companyId);
        if (!$penaltyIncome) throw new \RuntimeException("Account 'Penalty Income' not found");
        return $this->post($bankAccountId, $penaltyIncome->id, $amount, $currency, $date, "Repayment Penalty – {$ref}", $companyId);
    }

    /**
     * Interest Accrual: Dr Interest Receivable / Cr Interest Income
     */
    public function postInterestAccrual(float $amount, string $currency, string $date, int $companyId, string $loanRef): string
    {
        $interestReceivable = $this->findAccount('Interest Receivable', $companyId);
        $interestIncome     = $this->findAccount('Interest Income', $companyId);
        if (!$interestReceivable || !$interestIncome) throw new \RuntimeException("Interest accounts not found");
        return $this->post($interestReceivable->id, $interestIncome->id, $amount, $currency, $date, "Interest Accrual – {$loanRef}", $companyId);
    }

    /**
     * Write-off: Dr Bad Debt Expense / Cr Loan Receivable
     */
    public function postWriteoff(float $amount, string $currency, string $date, int $companyId, string $loanRef): string
    {
        $badDebt        = $this->findAccount('Bad Debt', $companyId);
        $loanReceivable = $this->findAccount('Loan Receivable', $companyId);
        if (!$badDebt || !$loanReceivable) throw new \RuntimeException("Write-off accounts not found");
        return $this->post($badDebt->id, $loanReceivable->id, $amount, $currency, $date, "Write-off – {$loanRef}", $companyId);
    }
}
