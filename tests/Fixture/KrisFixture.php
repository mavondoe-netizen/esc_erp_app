<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KrisFixture
 */
class KrisFixture extends TestFixture
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
                'risk_id' => 1,
                'metric' => 'Lorem ipsum dolor sit amet',
                'threshold' => 1.5,
                'current_value' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-08 16:36:24',
                'modified' => '2026-04-08 16:36:24',
            ],
        ];
        parent::init();
    }
}
