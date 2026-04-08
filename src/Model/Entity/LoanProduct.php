<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoanProduct Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string|null $code
 * @property string $interest_rate
 * @property string $interest_method
 * @property string $repayment_frequency
 * @property string $min_amount
 * @property string $max_amount
 * @property int $max_term
 * @property int $min_term
 * @property int $grace_period_days
 * @property string $penalty_rate
 * @property bool $requires_guarantor
 * @property string $currency
 * @property bool $is_active
 * @property string|null $description
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\LoanApplication[] $loan_applications
 * @property \App\Model\Entity\Loan[] $loans
 */
class LoanProduct extends Entity
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
        'name' => true,
        'code' => true,
        'interest_rate' => true,
        'interest_method' => true,
        'repayment_frequency' => true,
        'min_amount' => true,
        'max_amount' => true,
        'max_term' => true,
        'min_term' => true,
        'grace_period_days' => true,
        'penalty_rate' => true,
        'requires_guarantor' => true,
        'currency' => true,
        'is_active' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'loan_applications' => true,
        'loans' => true,
    ];
}
