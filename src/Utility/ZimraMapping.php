<?php
declare(strict_types=1);

namespace App\Utility;

class ZimraMapping
{
    /**
     * Get all available mapping options for Earnings and Deductions.
     * The ZIMRA report generator will use these base options and
     * split the values into USD or ZWG columns based on the 
     * currency of the Payslip Item.
     *
     * @return array<string, string>
     */
    public static function getOptions(): array
    {
        return [
            // Earnings
            'regular_earnings' => 'Current Salary, wages, fees, Commissions etc (regular earnings)',
            'other_exemptions' => 'Other Exemptions on Current Salary, Wages, Fees, Commissions Etc (Regular Earnings)',
            'overtime' => 'Current Overtime',
            'bonus' => 'Current Bonus',
            'cumulative_bonus' => 'Cumulative Bonus (from last tax period)',
            'irregular_commission' => 'Current Irregular Commission',
            'other_irregular_earnings' => 'Current Other Irregular earnings',
            'severance_pay' => 'Current Severance pay, gratuity or similar benefit, on retrenchment (with exemption)',
            'gratuity_no_exemption' => 'Current Gratuity without exemption',
            'housing_benefit' => 'Current Housing Benefit',
            'vehicle_benefit' => 'Current Vehicle Benefit',
            'education_benefit' => 'Current Education Benefit',
            'other_benefits' => 'Current Other Benefits',
            'non_taxable_earnings' => 'Current Non-Taxable Earnings',
            
            // Deductions
            'pension' => 'Current Pension Contributions',
            'nssa' => 'Current NSSA Contributions',
            'retirement_annuity' => 'Current Retirement Annuity Fund Contributions',
            'nec_subscriptions' => 'Current NEC/Subscriptions',
            'medical_aid' => 'Current Medical Aid Contributions',
            'medical_expenses' => 'Current Medical Expenses',
            'other_deductions' => 'Current Other Deductions',
        ];
    }
}
