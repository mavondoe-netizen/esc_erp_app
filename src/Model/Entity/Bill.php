<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bill Entity
 *
 * @property int $id
 * @property int $supplier_id
 * @property \Cake\I18n\Date $date
 * @property string $description
 * @property string $currency
 * @property float $total
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Bill extends Entity
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
        'supplier_id' => true,
        'date' => true,
        'description' => true,
        'currency' => true,
        'total' => true,
        'company_id' => true,
        'supplier' => true,
        'transactions' => true,
        'account_id' => true,
        'accounts' => true,
    ];
}
