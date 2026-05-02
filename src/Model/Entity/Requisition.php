<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Requisition Entity
 *
 * @property int $id
 * @property int $department_id
 * @property int $requested_by
 * @property string|null $description
 * @property string|null $total_estimated_cost
 * @property string|null $status
 * @property int|null $company_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Department $department
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Procurement[] $procurements
 * @property \App\Model\Entity\RequisitionItem[] $requisition_items
 */
class Requisition extends Entity
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
        'department_id' => true,
        'requested_by' => true,
        'description' => true,
        'total_estimated_cost' => true,
        'status' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'department' => true,
        'company' => true,
        'procurements' => true,
        'requisition_items' => true,
        'manual_reference' => true,
    ];
}
