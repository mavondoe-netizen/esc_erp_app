<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PayslipItem Entity
 *
 * @property int $id
 * @property int $payslip_id
 * @property string $item_type
 * @property string $name
 * @property string $amount
 *
 * @property \App\Model\Entity\Payslip $payslip
 */
class PayslipItem extends Entity
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
        'payslip_id' => true,
        'item_type' => true,
        'name' => true,
        'amount' => true,
        'currency' => true,
        'is_permanent' => true,
        'payslip' => true,
    ];
}
