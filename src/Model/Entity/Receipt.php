<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Receipt Entity
 *
 * @property int $id
 * @property int $supplier_id
 * @property string $currency
 * @property float $amount
 * @property int|null $account_id
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Contact $contact
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Receipt extends Entity
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
        'currency' => true,
        'amount' => true,
        'account_id' => true,
        'company_id' => true,
        
        'account' => true,
        'transactions' => true,
    ];
}
