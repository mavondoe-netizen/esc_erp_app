<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SalaryStructuresFixture
 */
class SalaryStructuresFixture extends TestFixture
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
                'role_id' => 1,
                'currency' => 'L',
                'basic_salary' => 1.5,
                'payment_frequency' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'created' => '2026-03-07 09:13:05',
                'modified' => '2026-03-07 09:13:05',
            ],
        ];
        parent::init();
    }
}
