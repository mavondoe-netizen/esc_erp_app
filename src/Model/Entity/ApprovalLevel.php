<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ApprovalLevel Entity
 *
 * @property int $id
 * @property string $entity
 * @property int $level
 * @property string|null $role
 * @property string|null $min_value
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class ApprovalLevel extends Entity
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
        'entity' => true,
        'level' => true,
        'role' => true,
        'min_value' => true,
        'created' => true,
        'modified' => true,
    ];
}
