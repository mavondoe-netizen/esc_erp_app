<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property int|null $bank_transaction_id
 * @property \Cake\I18n\Date $date
 * @property string $description
 * @property string $currency
 * @property float $amount
 * @property float $zwg
 * @property string $type
 * @property int $account_id
 * @property int|null $department_id
 * @property int|null $building_id
 * @property int|null $tenant_id
 * @property int|null $supplier_id
 * @property int|null $customer_id
 * @property int|null $company_id
 * @property int|null $payperiod_id
 * @property int|null $bill_id
 * @property int|null $invoice_id
 * @property string|null $transaction_group
 *
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Department $department
 * @property \App\Model\Entity\Building $building
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\PayPeriod $payperiod
 * @property \App\Model\Entity\BankTransaction[] $bank_transactions
 * @property \App\Model\Entity\Bill[] $bills
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\Receipt[] $receipts
 */
class Transaction extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity()
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'bank_transaction_id' => true,
        'date' => true,
        'description' => true,
        'currency' => true,
        'amount' => true,
        'zwg' => true,
        'type' => true,
        'account_id' => true,
        'department_id' => true,
        'building_id' => true,
        'tenant_id' => true,
        'supplier_id' => true,
        'customer_id' => true,
        'company_id' => true,
        'payperiod_id' => true,
        'bill_id' => true,
        'invoice_id' => true,
        'transaction_group' => true,
        'account' => true,
        'department' => true,
        'building' => true,
        'tenant' => true,
        'supplier' => true,
        'customer' => true,
        'company' => true,
        'payperiod' => true,
        'bank_transactions' => true,
        'bills' => true,
        'invoices' => true,
        'receipts' => true,
    ];
}
