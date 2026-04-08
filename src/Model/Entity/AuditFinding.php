<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditFinding Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $audit_id
 * @property string $finding
 * @property string $risk_level
 * @property string|null $root_cause
 * @property string|null $recommendation
 * @property string|null $management_response
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Audit $audit
 */
class AuditFinding extends Entity
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
        'audit_id' => true,
        'finding' => true,
        'risk_level' => true,
        'root_cause' => true,
        'recommendation' => true,
        'management_response' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'audit' => true,
    ];
}
