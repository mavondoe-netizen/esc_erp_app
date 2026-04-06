<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PayrollRunsFixture
 */
class PayrollRunsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'period_start' => '2026-03-08',
                'period_end' => '2026-03-08',
                'currency' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-03-08 03:14:07',
                'modified' => '2026-03-08 03:14:07',
            ],
        ];
        parent::init();
    }
}
