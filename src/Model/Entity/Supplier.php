<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Supplier Entity
 *
 * @property int $id
 * @property string $name
 * @property int $contact_id
 * @property string $industry
 *
 * @property \App\Model\Entity\Contact $contact
 * @property \App\Model\Entity\Bill[] $bills
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Supplier extends Entity
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
        'contact_id' => true,
        'industry' => true,
        'contact' => true,
        'bills' => true,
        'transactions' => true,
    ];
}
