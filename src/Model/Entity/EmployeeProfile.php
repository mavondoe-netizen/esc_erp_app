<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeProfile Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $employee_id_number
 * @property string|null $tax_number
 * @property string|null $social_security_number
 * @property \Cake\I18n\Date|null $hire_date
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\User $user
 */
class EmployeeProfile extends Entity
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
        'employee_id_number' => true,
        'tax_number' => true,
        'social_security_number' => true,
        'hire_date' => true,
        'created' => true,
        'modified' => true,
        'company_id' => true,
        'user' => true,
    ];
}
