<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoanApplication Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $client_id
 * @property int $loan_product_id
 * @property string $amount_requested
 * @property string $currency
 * @property int $term
 * @property string|null $purpose
 * @property string $status
 * @property \Cake\I18n\DateTime|null $submitted_at
 * @property \Cake\I18n\DateTime|null $decided_at
 * @property int|null $decided_by
 * @property string|null $rejection_reason
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\LoanProduct $loan_product
 * @property \App\Model\Entity\LoanGuarantor[] $loan_guarantors
 * @property \App\Model\Entity\Loan[] $loans
 */
class LoanApplication extends Entity
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
        'loan_product_id' => true,
        'amount_requested' => true,
        'currency' => true,
        'term' => true,
        'purpose' => true,
        'status' => true,
        'submitted_at' => true,
        'decided_at' => true,
        'decided_by' => true,
        'rejection_reason' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'loan_product' => true,
        'loan_guarantors' => true,
        'loans' => true,
    ];
}
