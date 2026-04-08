<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Control Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $risk_id
 * @property string $control_name
 * @property string|null $control_type
 * @property string|null $frequency
 * @property int|null $owner_id
 * @property string|null $effectiveness_rating
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Risk $risk
 * @property \App\Model\Entity\ControlTest[] $control_tests
 */
class Control extends Entity
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
        'risk_id' => true,
        'control_name' => true,
        'control_type' => true,
        'frequency' => true,
        'owner_id' => true,
        'effectiveness_rating' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'risk' => true,
        'control_tests' => true,
    ];
}
