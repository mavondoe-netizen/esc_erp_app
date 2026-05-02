<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Company Entity
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Account[] $accounts
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\Employee[] $employees
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\PayslipItem[] $payslip_items
 * @property \App\Model\Entity\Payslip[] $payslips
 * @property \App\Model\Entity\Product[] $products
 * @property \App\Model\Entity\Transaction[] $transactions
 * @property \App\Model\Entity\User[] $users
 */
class Company extends Entity
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
        'address' => true,
        'phone' => true,
        'email' => true,
        'logo' => true,
        'reporting_currency' => true,
        'license_expiry_date' => true,
        'created' => true,
        'modified' => true,
        'accounts' => true,
        'customers' => true,
        'employees' => true,
        'invoices' => true,
        'payslip_items' => true,
        'payslips' => true,
        'products' => true,
        'transactions' => true,
        'users' => true,
        'permissions' => true,
    ];
}
