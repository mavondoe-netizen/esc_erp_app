<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Procurement Entity
 *
 * @property int $id
 * @property int $requisition_id
 * @property string $procurement_method
 * @property int|null $assigned_to
 * @property string|null $status
 * @property int|null $company_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Requisition $requisition
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Tender[] $tenders
 */
class Procurement extends Entity
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
        'requisition_id' => true,
        'procurement_method' => true,
        'assigned_to' => true,
        'status' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'requisition' => true,
        'company' => true,
        'tenders' => true,
    ];
}
