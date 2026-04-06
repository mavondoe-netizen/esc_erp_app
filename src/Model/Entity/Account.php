<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Account Entity
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string $type
 *
 * @property \App\Model\Entity\Benefit[] $benefits
 * @property \App\Model\Entity\BillItem[] $bill_items
 * @property \App\Model\Entity\InvoiceItem[] $invoice_items
 * @property \App\Model\Entity\Receipt[] $receipts
 * @property \App\Model\Entity\Transaction[] $transactions
 * @property \App\Model\Entity\Invoice[] $invoices
 */
class Account extends Entity
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
        'category' => true,
        'type' => true,
        'subcategory' => true,
        'benefits' => true,
        'bill_items' => true,
        'invoice_items' => true,
        'receipts' => true,
        'transactions' => true,
        'invoices' => true,
    ];
}
