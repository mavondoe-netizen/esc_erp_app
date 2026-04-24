<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Levy Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $enrolment_id
 * @property int|null $tenant_id
 * @property int|null $unit_id
 * @property int|null $building_id
 * @property string $levy_type
 * @property string $amount
 * @property string $currency
 * @property \Cake\I18n\Date|null $due_date
 * @property bool $paid
 * @property \Cake\I18n\Date|null $paid_date
 * @property int|null $account_id
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
 * @property \App\Model\Entity\LevyItem[] $levy_items
 */
class Levy extends Entity
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
        'levy_type' => true,
        'amount' => true,
        'currency' => true,
        'due_date' => true,
        'paid' => true,
        'paid_date' => true,
        'account_id' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'enrolment' => true,
        'tenant' => true,
        'unit' => true,
        'building' => true,
        'account' => true,
        'levy_items' => true,
    ];
}
