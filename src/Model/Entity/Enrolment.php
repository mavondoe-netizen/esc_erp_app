<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Enrolment Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $unit_id
 * @property \Cake\I18n\DateTime $start_date
 * @property \Cake\I18n\DateTime|null $end_date
 * @property string $rate
 * @property string|null $status
 *
 * @property \App\Model\Entity\Unit $unit
 */
class Enrolment extends Entity
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
        'tenant_id' => true,
        'unit_id' => true,
        'start_date' => true,
        'end_date' => true,
        'rate' => true,
        'status' => true,
        'unit' => true,
    ];
}
