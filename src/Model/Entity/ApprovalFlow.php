<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ApprovalFlow Entity
 *
 * @property int $id
 * @property string $module_name
 * @property int $level
 * @property int $role_id
 * @property string|null $description
 * @property \Cake\I18n\DateTime|null $created
 *
 * @property \App\Model\Entity\Role $role
 */
class ApprovalFlow extends Entity
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
        'module_name' => true,
        'level' => true,
        'role_id' => true,
        'description' => true,
        'created' => true,
        'role' => true,
    ];
}
