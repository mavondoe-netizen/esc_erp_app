<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LeaveBalancesFixture
 */
class LeaveBalancesFixture extends TestFixture
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
                'leave_type_id' => 1,
                'year' => 1,
                'days_entitled' => 1.5,
                'days_taken' => 1.5,
                'created' => '2026-03-15 11:17:30',
                'modified' => '2026-03-15 11:17:30',
            ],
        ];
        parent::init();
    }
}
