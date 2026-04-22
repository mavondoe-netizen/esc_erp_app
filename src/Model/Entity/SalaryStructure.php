<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SalaryStructure Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $role_id
 * @property string $currency
 * @property string $basic_salary
 * @property string|null $payment_frequency
 * @property bool|null $is_active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\PayrollRecord[] $payroll_records
 */
class SalaryStructure extends Entity
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
        'user_id' => true,
        'role_id' => true,
        'currency' => true,
        'basic_salary' => true,
        'payment_frequency' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'company_id' => true,
        'user' => true,
        'role' => true,
        'payroll_records' => true,
    ];
}
