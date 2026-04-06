<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PayrollRecordsFixture
 */
class PayrollRecordsFixture extends TestFixture
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
                'user_id' => 1,
                'salary_structure_id' => 1,
                'payroll_month' => 'Lorem ip',
                'base_salary_amount' => 1.5,
                'total_earnings' => 1.5,
                'total_deductions' => 1.5,
                'net_pay' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'currency' => 'L',
                'created' => '2026-03-07 09:13:48',
                'modified' => '2026-03-07 09:13:48',
            ],
        ];
        parent::init();
    }
}
