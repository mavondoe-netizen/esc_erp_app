<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoanGuarantor Entity
 *
 * @property int $id
 * @property int $loan_application_id
 * @property string $name
 * @property string|null $national_id
 * @property string|null $relationship
 * @property string|null $phone
 * @property string|null $employer
 * @property string|null $monthly_income
 * @property string $currency
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\LoanApplication $loan_application
 */
class LoanGuarantor extends Entity
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
        'loan_application_id' => true,
        'name' => true,
        'national_id' => true,
        'relationship' => true,
        'phone' => true,
        'employer' => true,
        'monthly_income' => true,
        'currency' => true,
        'status' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'loan_application' => true,
    ];
}
