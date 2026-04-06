<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payslip Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property int $pay_period_id
 * @property string $gross_pay
 * @property string|null $deductions
 * @property string $net_pay
 * @property \Cake\I18n\Date $generated_date
 * @property string $basic_salary
 * @property string $allowances
 * @property string $bonuses
 * @property string $overtime
 * @property string $benefits
 * @property string $pension
 * @property string $nssa
 * @property string $medical_aid
 * @property string $medical_expenses
 * @property string $taxable_income
 * @property string $paye
 * @property string $tax_credits
 * @property string $aids_levy
 * @property string $total_tax
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\PayPeriod $pay_period
 */
class Payslip extends Entity
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
        'employee_id' => true,
        'pay_period_id' => true,
        'gross_pay' => true,
        'deductions' => true,
        'net_pay' => true,
        'generated_date' => true,
        'basic_salary' => true,
        'allowances' => true,
        'bonuses' => true,
        'overtime' => true,
        'benefits' => true,
        'pension' => true,
        'nssa' => true,
        'medical_aid' => true,
        'medical_expenses' => true,
        'taxable_income' => true,
        'paye' => true,
        'tax_credits' => true,
        'aids_levy' => true,
        'total_tax' => true,
        'employee' => true,
        'pay_period' => true,
        'payslip_items' => true,
        'exchange_rate' => true,
        'usd_gross' => true,
        'usd_deductions' => true,
        'usd_net' => true,
        'zwg_gross' => true,
        'zwg_deductions' => true,
        'zwg_net' => true,
    ];
}
