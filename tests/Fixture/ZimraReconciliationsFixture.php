<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ZimraReconciliationsFixture
 */
class ZimraReconciliationsFixture extends TestFixture
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
                'company_id' => 1,
                'employee_id' => 1,
                'pay_period_id' => 1,
                'payroll_tax_amount' => 1.5,
                'assessed_tax_amount' => 1.5,
                'variance' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'cleared_date' => '2026-04-09',
                'cleared_via' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-09 17:18:00',
                'modified' => '2026-04-09 17:18:00',
            ],
        ];
        parent::init();
    }
}
