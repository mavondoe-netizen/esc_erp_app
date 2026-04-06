<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditLog Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $model
 * @property string $record_id
 * @property string $action
 * @property string|null $changed_data
 * @property \Cake\I18n\DateTime|null $created
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\User $user
 */
class AuditLog extends Entity
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
        'model' => true,
        'record_id' => true,
        'action' => true,
        'changed_data' => true,
        'created' => true,
        'company_id' => true,
        'user' => true,
    ];
}
