<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PayPeriodsFixture
 */
class PayPeriodsFixture extends TestFixture
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
                'name' => 'Lorem ',
                'start_date' => '2026-03-15',
                'end_date' => '2026-03-15',
                'status' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
