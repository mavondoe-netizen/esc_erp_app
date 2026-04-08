<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LoanClient Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $employee_id
 * @property string $name
 * @property string|null $national_id
 * @property \Cake\I18n\Date|null $dob
 * @property string|null $gender
 * @property string|null $employer_name
 * @property string|null $employment_type
 * @property string $monthly_income
 * @property string $income_currency
 * @property string|null $contact_phone
 * @property string|null $contact_email
 * @property string|null $address
 * @property string $status
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Employee $employee
 */
class LoanClient extends Entity
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
        'employee_id' => true,
        'name' => true,
        'national_id' => true,
        'dob' => true,
        'gender' => true,
        'employer_name' => true,
        'employment_type' => true,
        'monthly_income' => true,
        'income_currency' => true,
        'contact_phone' => true,
        'contact_email' => true,
        'address' => true,
        'status' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'employee' => true,
    ];
}
