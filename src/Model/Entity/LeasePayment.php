<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LeasePayment Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $enrolment_id
 * @property int|null $tenant_id
 * @property int|null $unit_id
 * @property int|null $building_id
 * @property int|null $account_id
 * @property string $amount
 * @property string $currency
 * @property string|null $payment_mode
 * @property string|null $reference
 * @property string|null $period_covered
 * @property \Cake\I18n\Date $date
 * @property string|null $description
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Enrolment $enrolment
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Unit $unit
 * @property \App\Model\Entity\Building $building
 * @property \App\Model\Entity\Account $account
 */
class LeasePayment extends Entity
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
        'enrolment_id' => true,
        'tenant_id' => true,
        'unit_id' => true,
        'building_id' => true,
        'account_id' => true,
        'amount' => true,
        'currency' => true,
        'payment_mode' => true,
        'reference' => true,
        'period_covered' => true,
        'date' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'enrolment' => true,
        'tenant' => true,
        'unit' => true,
        'building' => true,
        'account' => true,
    ];
}
