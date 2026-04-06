<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estimate Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $customer_id
 * @property \Cake\I18n\Date $date
 * @property \Cake\I18n\Date|null $expiry_date
 * @property string|null $description
 * @property string|null $total
 * @property string|null $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\EstimateItem[] $estimate_items
 */
class Estimate extends Entity
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
        'customer_id' => true,
        'date' => true,
        'expiry_date' => true,
        'description' => true,
        'total' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'customer' => true,
        'estimate_items' => true,
    ];
}
