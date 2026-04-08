<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RiskAssessment Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $risk_id
 * @property int $likelihood
 * @property int $impact
 * @property int $control_effectiveness
 * @property string $risk_rating
 * @property int|null $assessed_by
 * @property \Cake\I18n\DateTime|null $assessed_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Risk $risk
 */
class RiskAssessment extends Entity
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
        'likelihood' => true,
        'impact' => true,
        'control_effectiveness' => true,
        'risk_rating' => true,
        'assessed_by' => true,
        'assessed_at' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'risk' => true,
    ];
}
