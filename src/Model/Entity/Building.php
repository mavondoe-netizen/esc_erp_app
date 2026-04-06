<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Building Entity
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property int $investor_id
 * @property \Cake\I18n\DateTime $start_date
 * @property bool $isvacant
 *
 * @property \App\Model\Entity\Investor $investor
 * @property \App\Model\Entity\Bill[] $bills
 * @property \App\Model\Entity\Transaction[] $transactions
 * @property \App\Model\Entity\Unit[] $units
 */
class Building extends Entity
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
        'investor_id' => true,
        'start_date' => true,
        'isvacant' => true,
        'investor' => true,
        'bills' => true,
        'transactions' => true,
        'units' => true,
    ];
}
