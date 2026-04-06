<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EnrolmentsFixture
 */
class EnrolmentsFixture extends TestFixture
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
                'tenant_id' => 1,
                'unit_id' => 1,
                'start_date' => '2025-09-23 02:46:10',
                'end_date' => '2025-09-23 02:46:10',
                'rate' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
