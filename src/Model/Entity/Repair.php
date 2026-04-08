<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Repair Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $unit_id
 * @property int|null $building_id
 * @property int|null $tenant_id
 * @property string $title
 * @property string|null $description
 * @property string|null $category
 * @property string $status
 * @property \Cake\I18n\Date|null $reported_date
 * @property \Cake\I18n\Date|null $resolved_date
 * @property string|null $cost
 * @property string|null $currency
 * @property int|null $account_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Unit $unit
 * @property \App\Model\Entity\Building $building
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Account $account
 */
class Repair extends Entity
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
        'unit_id' => true,
        'building_id' => true,
        'tenant_id' => true,
        'title' => true,
        'description' => true,
        'category' => true,
        'status' => true,
        'reported_date' => true,
        'resolved_date' => true,
        'cost' => true,
        'currency' => true,
        'account_id' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'unit' => true,
        'building' => true,
        'tenant' => true,
        'account' => true,
    ];
}
