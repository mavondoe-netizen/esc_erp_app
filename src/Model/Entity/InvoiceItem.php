<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoiceItem Entity
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $account_id
 * @property int $quantity
 * @property float $unit_price
 * @property float $line_total
 * @property int|null $product_id
 *
 * @property \App\Model\Entity\Invoice $invoice
 * @property \App\Model\Entity\Account $account
 */
class InvoiceItem extends Entity
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
        'invoice_id' => true,
        'account_id' => true,
        'quantity' => true,
        'unit_price' => true,
        'line_total' => true,
        'product_id' => true,
        'vat_rate' => true,
        'vat_amount' => true,
        'hs_code' => true,
        'vat_type' => true,
        'invoice' => true,
        'account' => true,
    ];
}
