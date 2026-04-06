<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Deduction Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $statutory
 * @property bool $tax_deductible
 * @property string $calculation_type
 */
class Deduction extends Entity
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
        'statutory' => true,
        'tax_deductible' => true,
        'calculation_type' => true,
        'zimra_mapping' => true,
    ];
}
