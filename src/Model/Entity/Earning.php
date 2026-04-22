<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Earning Entity
 *
 * @property int $id
 * @property string $name
 * @property int $account_id
 * @property bool $taxable
 * @property bool $pensionable
 * @property bool $nssa_applicable
 * @property string $calculation_type
 * @property bool|null $gross_up
 * @property string|null $taxable_percentage
 * @property string|null $tax_free_amount
 * @property string|null $zimra_mapping
 * @property int|null $company_id
 *
 * @property \App\Model\Entity\Account $account
 */
class Earning extends Entity
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
        'account_id' => true,
        'taxable' => true,
        'pensionable' => true,
        'nssa_applicable' => true,
        'calculation_type' => true,
        'gross_up' => true,
        'taxable_percentage' => true,
        'tax_free_amount' => true,
        'zimra_mapping' => true,
        'company_id' => true,
        'account' => true,
    ];
}
