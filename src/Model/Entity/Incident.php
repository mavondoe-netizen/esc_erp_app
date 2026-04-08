<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Incident Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $title
 * @property string|null $description
 * @property string $type
 * @property int|null $business_unit_id
 * @property int|null $reported_by
 * @property \Cake\I18n\DateTime|null $reported_at
 * @property string|null $severity
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\LossEvent[] $loss_events
 */
class Incident extends Entity
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
        'company_id' => true,
        'title' => true,
        'description' => true,
        'type' => true,
        'business_unit_id' => true,
        'reported_by' => true,
        'reported_at' => true,
        'severity' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'loss_events' => true,
    ];
}
