<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PayslipsFixture
 */
class PayslipsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'employee_id' => 1,
                'pay_period_id' => 1,
                'gross_pay' => 1.5,
                'deductions' => 1.5,
                'net_pay' => 1.5,
                'generated_date' => '2026-03-08',
                'basic_salary' => 1.5,
                'allowances' => 1.5,
                'bonuses' => 1.5,
                'overtime' => 1.5,
                'benefits' => 1.5,
                'pension' => 1.5,
                'nssa' => 1.5,
                'medical_aid' => 1.5,
                'medical_expenses' => 1.5,
                'taxable_income' => 1.5,
                'paye' => 1.5,
                'tax_credits' => 1.5,
                'aids_levy' => 1.5,
                'total_tax' => 1.5,
            ],
        ];
        parent::init();
    }
}
