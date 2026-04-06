<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditTrail Entity
 *
 * @property int $id
 * @property string $entity_type
 * @property int $entity_id
 * @property string $action
 * @property string $description
 * @property int $user_id
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\User $user
 */
class AuditTrail extends Entity
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
        'entity_type' => true,
        'entity_id' => true,
        'action' => true,
        'description' => true,
        'user_id' => true,
        'created' => true,
        'user' => true,
    ];
}
