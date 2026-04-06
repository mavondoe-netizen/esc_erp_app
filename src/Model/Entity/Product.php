<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property int $account_id
 * @property string $unit_price
 * @property string $vat_rate
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\InvoiceItem[] $invoice_items
 */
class Product extends Entity
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
        'name' => true,
        'account_id' => true,
        'unit_price' => true,
        'vat_rate' => true,
        'created' => true,
        'modified' => true,
        'account' => true,
        'invoice_items' => true,
    ];
}
