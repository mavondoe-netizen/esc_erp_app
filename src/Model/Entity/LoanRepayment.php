<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoanRepayment Entity
 *
 * @property int $id
 * @property int $loan_id
 * @property int|null $client_id
 * @property string $amount
 * @property string $currency
 * @property string $source
 * @property \Cake\I18n\Date $payment_date
 * @property string $penalty_paid
 * @property string $interest_paid
 * @property string $principal_paid
 * @property string|null $reference
 * @property int|null $account_id
 * @property int|null $processed_by
 * @property string|null $allocation_json
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Loan $loan
 * @property \App\Model\Entity\Account $account
 */
class LoanRepayment extends Entity
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
        'loan_id' => true,
        'client_id' => true,
        'amount' => true,
        'currency' => true,
        'source' => true,
        'payment_date' => true,
        'penalty_paid' => true,
        'interest_paid' => true,
        'principal_paid' => true,
        'reference' => true,
        'account_id' => true,
        'processed_by' => true,
        'allocation_json' => true,
        'notes' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'loan' => true,
        'account' => true,
    ];
}
