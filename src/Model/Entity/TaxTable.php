<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TaxTable Entity
 *
 * @property int $id
 * @property string $currency
 * @property int $lower_limit
 * @property int $upper_limit
 * @property float $rate
 * @property float $deduction
 * @property \Cake\I18n\Date $tax_year
 */
class TaxTable extends Entity
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
        'currency' => true,
        'lower_limit' => true,
        'upper_limit' => true,
        'rate' => true,
        'deduction' => true,
        'tax_year' => true,
    ];
}
