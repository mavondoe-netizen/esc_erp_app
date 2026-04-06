<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmployeesFixture
 */
class EmployeesFixture extends TestFixture
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
                'employee_code' => 'Lorem ipsum dolor ',
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'nssa_number' => 1,
                'tax_number' => 1,
                'date_of_birth' => '2026-04-05',
                'disabled' => 1,
                'designation' => 'Lorem ipsum dolor sit amet',
                'basic_salary' => 1.5,
                'created' => '2026-04-05 04:59:55',
                'modified' => '2026-04-05 04:59:55',
                'national_identity' => 'Lorem ipsum dolor sit amet',
                'company_id' => 1,
                'is_blind' => 1,
                'usd_bank' => 'Lorem ipsum dolor sit amet',
                'usd_branch' => 'Lorem ipsum dolor sit amet',
                'usd_account' => 'Lorem ipsum dolor sit amet',
                'zwg_bank' => 'Lorem ipsum dolor sit amet',
                'zwg_branch' => 'Lorem ipsum dolor sit amet',
                'zwg_account' => 'Lorem ipsum dolor sit amet',
                'start_date' => '2026-04-05',
                'termination_date' => '2026-04-05',
            ],
        ];
        parent::init();
    }
}
