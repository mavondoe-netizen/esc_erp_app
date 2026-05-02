<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Receipt Entity
 *
 * @property int $id
 * @property int $supplier_id
 * @property int|null $customer_id
 * @property string|null $date
 * @property string|null $reference
 * @property string|null $description
 * @property string $status
 * @property string $currency
 * @property float $amount
 * @property int|null $account_id
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Receipt extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'supplier_id'  => true,
        'customer_id'  => true,
        'date'         => true,
        'reference'    => true,
        'description'  => true,
        'status'       => true,
        'currency'     => true,
        'amount'       => true,
        'account_id'   => true,
        'company_id'   => true,
        'customer'     => true,
        'account'      => true,
        'transactions' => true,
        'manual_reference' => true,
    ];
}
