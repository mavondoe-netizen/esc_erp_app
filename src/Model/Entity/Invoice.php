<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
 *
 * @property int $id
 * @property \Cake\I18n\Date $date
 * @property int $customer_id
 * @property string $currency
 * @property string $description
 * @property string $status
 * @property float $total
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\InvoiceItem[] $invoice_items
 * @property \App\Model\Entity\Account[] $accounts
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Invoice extends Entity
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
        'date' => true,
        'customer_id' => true,
        'currency' => true,
        'description' => true,
        'status' => true,
        'total' => true,
        'company_id' => true,
        'customer' => true,
        'invoice_items' => true,
        'accounts' => true,
        'account_id'=> true,
        'transactions' => true,
        'line_total'=> true,
        'manual_reference' => true,
    ];
}
