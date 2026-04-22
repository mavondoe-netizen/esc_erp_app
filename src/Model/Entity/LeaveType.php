<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LeaveType Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $default_days_per_year
 * @property bool $is_active
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\LeaveApplication[] $leave_applications
 * @property \App\Model\Entity\LeaveBalance[] $leave_balances
 */
class LeaveType extends Entity
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
        'name' => true,
        'description' => true,
        'default_days_per_year' => true,
        'is_active' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'leave_applications' => true,
        'leave_balances' => true,
    ];
}
