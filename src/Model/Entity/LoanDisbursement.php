<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoanDisbursement Entity
 *
 * @property int $id
 * @property int $loan_id
 * @property string $amount
 * @property string $currency
 * @property string $method
 * @property string|null $bank_reference
 * @property int|null $account_id
 * @property int|null $disbursed_by
 * @property \Cake\I18n\DateTime|null $disbursed_at
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Loan $loan
 * @property \App\Model\Entity\Account $account
 */
class LoanDisbursement extends Entity
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
        'amount' => true,
        'currency' => true,
        'method' => true,
        'bank_reference' => true,
        'account_id' => true,
        'disbursed_by' => true,
        'disbursed_at' => true,
        'notes' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'loan' => true,
        'account' => true,
    ];
}
