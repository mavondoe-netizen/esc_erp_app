<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GoodsReceipt Entity
 *
 * @property int $id
 * @property int $contract_id
 * @property int $received_by
 * @property \Cake\I18n\DateTime $received_date
 * @property string|null $status
 * @property int|null $company_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Contract $contract
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\GoodsReceiptItem[] $goods_receipt_items
 */
class GoodsReceipt extends Entity
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
        'contract_id' => true,
        'received_by' => true,
        'received_date' => true,
        'status' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'contract' => true,
        'company' => true,
        'goods_receipt_items' => true,
    ];
}
