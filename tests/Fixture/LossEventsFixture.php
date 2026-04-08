<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LossEventsFixture
 */
class LossEventsFixture extends TestFixture
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
                'incident_id' => 1,
                'amount' => 1.5,
                'recovery_amount' => 1.5,
                'net_loss' => 1.5,
                'created' => '2026-04-08 16:36:58',
                'modified' => '2026-04-08 16:36:58',
            ],
        ];
        parent::init();
    }
}
