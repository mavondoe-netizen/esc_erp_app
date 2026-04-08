<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LossEvent Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $incident_id
 * @property string $amount
 * @property string|null $recovery_amount
 * @property string|null $net_loss
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Incident $incident
 */
class LossEvent extends Entity
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
        'incident_id' => true,
        'amount' => true,
        'recovery_amount' => true,
        'net_loss' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'incident' => true,
    ];
}
