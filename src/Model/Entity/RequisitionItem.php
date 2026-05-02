<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RequisitionItem Entity
 *
 * @property int $id
 * @property int $requisition_id
 * @property string $item_description
 * @property string $quantity
 * @property string $estimated_unit_price
 * @property int|null $company_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Requisition $requisition
 * @property \App\Model\Entity\Company $company
 */
class RequisitionItem extends Entity
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
        'item_description' => true,
        'quantity' => true,
        'estimated_unit_price' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'requisition' => true,
        'company' => true,
    ];
}
