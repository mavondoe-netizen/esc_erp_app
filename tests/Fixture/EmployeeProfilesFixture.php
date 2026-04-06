<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmployeeProfilesFixture
 */
class EmployeeProfilesFixture extends TestFixture
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
                'employee_id_number' => 'Lorem ipsum dolor sit amet',
                'tax_number' => 'Lorem ipsum dolor sit amet',
                'social_security_number' => 'Lorem ipsum dolor sit amet',
                'hire_date' => '2026-03-07',
                'created' => '2026-03-07 09:12:42',
                'modified' => '2026-03-07 09:12:42',
            ],
        ];
        parent::init();
    }
}
