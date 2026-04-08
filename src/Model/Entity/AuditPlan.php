<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditPlan Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $year
 * @property int|null $business_unit_id
 * @property string $audit_type
 * @property \Cake\I18n\Date|null $planned_start
 * @property \Cake\I18n\Date|null $planned_end
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Audit[] $audits
 */
class AuditPlan extends Entity
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
        'year' => true,
        'business_unit_id' => true,
        'audit_type' => true,
        'planned_start' => true,
        'planned_end' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'audits' => true,
    ];
}
