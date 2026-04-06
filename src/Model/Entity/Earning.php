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
        'account' => true,
        'zimra_mapping' => true,
    ];
}
