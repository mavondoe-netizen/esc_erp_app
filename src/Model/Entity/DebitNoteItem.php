<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DebitNoteItem Entity
 *
 * @property int $id
 * @property int $debit_note_id
 * @property int|null $product_id
 * @property int $account_id
 * @property string|null $quantity
 * @property string|null $unit_price
 * @property string|null $line_total
 *
 * @property \App\Model\Entity\DebitNote $debit_note
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Account $account
 */
class DebitNoteItem extends Entity
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
        'debit_note_id' => true,
        'product_id' => true,
        'account_id' => true,
        'quantity' => true,
        'unit_price' => true,
        'line_total' => true,
        'vat_rate' => true,
        'vat_amount' => true,
        'debit_note' => true,
        'product' => true,
        'account' => true,
    ];
}
