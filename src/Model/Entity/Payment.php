<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $customer_id
 * @property int|null $account_id
 * @property string $amount
 * @property string $currency
 * @property string|null $payment_mode
 * @property string|null $reference
 * @property \Cake\I18n\Date $date
 * @property string|null $description
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Account $account
 */
class Payment extends Entity
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
        'company_id' => true,
        'customer_id' => true,
        'account_id' => true,
        'amount' => true,
        'currency' => true,
        'payment_mode' => true,
        'reference' => true,
        'date' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'customer' => true,
        'account' => true,
    ];
}
