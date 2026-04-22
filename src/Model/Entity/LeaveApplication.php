<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LeaveApplication Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type_id
 * @property \Cake\I18n\Date $start_date
 * @property \Cake\I18n\Date $end_date
 * @property string $days_requested
 * @property string|null $notes
 * @property string $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\LeaveType $leave_type
 */
class LeaveApplication extends Entity
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
        'employee_id' => true,
        'leave_type_id' => true,
        'start_date' => true,
        'end_date' => true,
        'days_requested' => true,
        'notes' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company_id' => true,
        'employee' => true,
        'leave_type' => true,
    ];
}
