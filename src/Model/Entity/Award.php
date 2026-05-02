<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Award Entity
 *
 * @property int $id
 * @property int $tender_id
 * @property int $supplier_id
 * @property string $awarded_amount
 * @property string|null $status
 * @property int|null $company_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Tender $tender
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Bill[] $bills
 * @property \App\Model\Entity\Contract[] $contracts
 */
class Award extends Entity
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
        'tender_id' => true,
        'supplier_id' => true,
        'awarded_amount' => true,
        'status' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'tender' => true,
        'supplier' => true,
        'company' => true,
        'bills' => true,
        'contracts' => true,
    ];
}
