<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Audit Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $audit_plan_id
 * @property string $title
 * @property string|null $scope
 * @property int|null $auditor_id
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\AuditPlan $audit_plan
 * @property \App\Model\Entity\AuditFinding[] $audit_findings
 */
class Audit extends Entity
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
        'audit_plan_id' => true,
        'title' => true,
        'scope' => true,
        'auditor_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'audit_plan' => true,
        'audit_findings' => true,
    ];
}
