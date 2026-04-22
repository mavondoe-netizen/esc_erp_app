<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact Entity
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property string $email
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\Email[] $emails

 * @property \App\Model\Entity\Meeting[] $meetings
 * @property \App\Model\Entity\Supplier[] $suppliers
 * @property \App\Model\Entity\Tenant[] $tenants
 */
class Contact extends Entity
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
        'mobile' => true,
        'email' => true,
        'company_id' => true,
        'customers' => true,
        'emails' => true,
        'meetings' => true,
        'suppliers' => true,
        'tenants' => true,
    ];
}
