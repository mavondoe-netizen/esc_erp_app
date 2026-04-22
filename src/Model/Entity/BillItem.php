<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillItem Entity
 *
 * @property int $id
 * @property int $bill_id
 * @property int|null $product_id
 * @property int $account_id
 * @property string|null $description
 * @property int $quantity
 * @property float $unit_price
 * @property float $line_total
 * @property float|null $vat_rate
 * @property string|null $vat_type
 * @property string|null $hs_code
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Bill $bill
 * @property \App\Model\Entity\Product|null $product
 * @property \App\Model\Entity\Account $account
 */
class BillItem extends Entity
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
        'bill_id' => true,
        'product_id' => true,
        'account_id' => true,
        'description' => true,
        'quantity' => true,
        'unit_price' => true,
        'line_total' => true,
        'vat_rate' => true,
        'vat_type' => true,
        'hs_code' => true,
        'company_id' => true,
        'bill' => true,
        'product' => true,
        'account' => true,
    ];
}
