<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Risk Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $title
 * @property string|null $description
 * @property string $category
 * @property int|null $business_unit_id
 * @property int|null $owner_id
 * @property string|null $inherent_risk_score
 * @property string|null $residual_risk_score
 * @property string|null $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Control[] $controls
 * @property \App\Model\Entity\Kri[] $kris
 * @property \App\Model\Entity\RiskAssessment[] $risk_assessments
 */
class Risk extends Entity
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
        'category' => true,
        'business_unit_id' => true,
        'owner_id' => true,
        'inherent_risk_score' => true,
        'residual_risk_score' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'controls' => true,
        'kris' => true,
        'risk_assessments' => true,
    ];
}
