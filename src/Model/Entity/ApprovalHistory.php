<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ApprovalHistory Entity
 *
 * @property int $id
 * @property int $approval_id
 * @property string $action
 * @property int|null $level
 * @property int|null $performed_by
 * @property string|null $remarks
 * @property \Cake\I18n\DateTime|null $created
 *
 * @property \App\Model\Entity\Approval $approval
 */
class ApprovalHistory extends Entity
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
        'approval_id' => true,
        'action' => true,
        'level' => true,
        'performed_by' => true,
        'remarks' => true,
        'created' => true,
        'approval' => true,
    ];
}
