<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ZimraReconciliation Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $employee_id
 * @property int $pay_period_id
 * @property string $payroll_tax_amount
 * @property string $assessed_tax_amount
 * @property string $variance
 * @property string $status
 * @property \Cake\I18n\Date|null $cleared_date
 * @property string|null $cleared_via
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\PayPeriod $pay_period
 */
class ZimraReconciliation extends Entity
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
        'employee_id' => true,
        'pay_period_id' => true,
        'payroll_tax_amount' => true,
        'assessed_tax_amount' => true,
        'variance' => true,
        'status' => true,
        'cleared_date' => true,
        'cleared_via' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'employee' => true,
        'pay_period' => true,
    ];
}
