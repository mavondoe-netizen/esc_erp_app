<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditAction Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $finding_id
 * @property int|null $assigned_to
 * @property \Cake\I18n\Date|null $due_date
 * @property string $status
 * @property \Cake\I18n\Date|null $completion_date
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 */
class AuditAction extends Entity
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
        'finding_id' => true,
        'assigned_to' => true,
        'due_date' => true,
        'status' => true,
        'completion_date' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
    ];
}
