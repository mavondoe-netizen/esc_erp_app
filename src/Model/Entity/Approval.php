<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Approval Entity
 *
 * @property int $id
 * @property string $table_name
 * @property int $entity_id
 * @property string|null $status
 * @property int $initiated_by
 * @property int|null $approved_by
 * @property string|null $remarks
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $approved_at
 */
class Approval extends Entity
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
        'table_name' => true,
        'entity_id' => true,
        'status' => true,
        'initiated_by' => true,
        'level' => true,
        'approved_by' => true,
        'remarks' => true,
        'created' => true,
        'approved_at' => true,
    ];
}
