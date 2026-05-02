<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GoodsReceiptItem Entity
 *
 * @property int $id
 * @property int $goods_receipt_id
 * @property string $description
 * @property string $quantity_received
 * @property int|null $company_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\GoodsReceipt $goods_receipt
 * @property \App\Model\Entity\Company $company
 */
class GoodsReceiptItem extends Entity
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
        'goods_receipt_id' => true,
        'description' => true,
        'quantity_received' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'goods_receipt' => true,
        'company' => true,
    ];
}
