<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Inspection Entity
 *
 * @property int $id
 * @property string $name
 * @property int $customer_id
 * @property \Cake\I18n\Date $date
 * @property float $pobs_insurable
 * @property float $apwcs_insurable
 * @property float $apwcs_penalty
 * @property int $inspector_id
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Inspector $inspector
 */
class Inspection extends Entity
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
        'customer_id' => true,
        'date' => true,
        'pobs_insurable' => true,
        'apwcs_insurable' => true,
        'apwcs_penalty' => true,
        'inspector_id' => true,
        'customer' => true,
        'inspector' => true,
    ];
}
