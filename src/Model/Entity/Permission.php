<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permission Entity
 *
 * @property int $id
 * @property int $role_id
 * @property string $model
 * @property bool|null $can_create
 * @property bool|null $can_read
 * @property bool|null $can_update
 * @property bool|null $can_delete
 * @property bool|null $can_approve
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Role $role
 */
class Permission extends Entity
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
        'role_id' => true,
        'model' => true,
        'can_create' => true,
        'can_read' => true,
        'can_update' => true,
        'can_delete' => true,
        'can_approve' => true,
        'created' => true,
        'modified' => true,
        'company_id' => true,
        'role' => true,
    ];
}
