<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Employee Entity
 *
 * @property int $id
 * @property string $employee_code
 * @property string $first_name
 * @property string $last_name
 * @property int $nssa_number
 * @property int $tax_number
 * @property \Cake\I18n\Date $date_of_birth
 * @property bool $disabled
 * @property string|null $designation
 * @property string $basic_salary
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $national_identity
 * @property int|null $company_id
 * @property bool $is_blind
 * @property string|null $usd_bank
 * @property string|null $usd_branch
 * @property string|null $usd_account
 * @property string|null $zwg_bank
 * @property string|null $zwg_branch
 * @property string|null $zwg_account
 * @property \Cake\I18n\Date|null $start_date
 * @property \Cake\I18n\Date|null $termination_date
 *
 * @property \App\Model\Entity\Payslip[] $payslips
 */
class Employee extends Entity
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
        'employee_code' => true,
        'first_name' => true,
        'last_name' => true,
        'nssa_number' => true,
        'tax_number' => true,
        'date_of_birth' => true,
        'disabled' => true,
        'designation' => true,
        'basic_salary' => true,
        'created' => true,
        'modified' => true,
        'national_identity' => true,
        'company_id' => true,
        'is_blind' => true,
        'usd_bank' => true,
        'usd_branch' => true,
        'usd_account' => true,
        'zwg_bank' => true,
        'zwg_branch' => true,
        'zwg_account' => true,
        'start_date' => true,
        'termination_date' => true,
        'payslips' => true,
    ];
}
