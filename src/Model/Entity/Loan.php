<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Loan Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $client_id
 * @property int|null $loan_application_id
 * @property int|null $loan_product_id
 * @property string|null $loan_account_no
 * @property string $principal
 * @property string $outstanding_balance
 * @property string $interest_rate
 * @property string $interest_method
 * @property string $repayment_frequency
 * @property int $term
 * @property string $currency
 * @property \Cake\I18n\Date|null $start_date
 * @property \Cake\I18n\Date|null $maturity_date
 * @property \Cake\I18n\DateTime|null $disbursed_at
 * @property \Cake\I18n\Date|null $last_payment_date
 * @property string $status
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\LoanApplication $loan_application
 * @property \App\Model\Entity\LoanProduct $loan_product
 * @property \App\Model\Entity\DelinquencyFlag[] $delinquency_flags
 * @property \App\Model\Entity\LoanDeduction[] $loan_deductions
 * @property \App\Model\Entity\LoanDisbursement[] $loan_disbursements
 * @property \App\Model\Entity\LoanRepayment[] $loan_repayments
 * @property \App\Model\Entity\LoanRestructure[] $loan_restructures
 * @property \App\Model\Entity\LoanSchedule[] $loan_schedules
 * @property \App\Model\Entity\LoanWriteoff[] $loan_writeoffs
 */
class Loan extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'company_id' => true,
        'client_id' => true,
        'loan_application_id' => true,
        'loan_product_id' => true,
        'loan_account_no' => true,
        'principal' => true,
        'outstanding_balance' => true,
        'interest_rate' => true,
        'interest_method' => true,
        'repayment_frequency' => true,
        'term' => true,
        'currency' => true,
        'start_date' => true,
        'maturity_date' => true,
        'disbursed_at' => true,
        'last_payment_date' => true,
        'status' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'loan_application' => true,
        'loan_product' => true,
        'delinquency_flags' => true,
        'loan_deductions' => true,
        'loan_disbursements' => true,
        'loan_repayments' => true,
        'loan_restructures' => true,
        'loan_schedules' => true,
        'loan_writeoffs' => true,
    ];
}
