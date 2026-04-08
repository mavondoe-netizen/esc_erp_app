<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ClientScoresFixture
 */
class ClientScoresFixture extends TestFixture
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
                'client_id' => 1,
                'score' => 1,
                'grade' => 'Lor',
                'risk_level' => 'Lorem ipsum dolor ',
                'debt_ratio' => 1.5,
                'repayment_history_score' => 1.5,
                'delinquency_score' => 1.5,
                'active_loans_count' => 1,
                'computed_at' => '2026-04-07 19:36:25',
                'created' => '2026-04-07 19:36:25',
                'modified' => '2026-04-07 19:36:25',
            ],
        ];
        parent::init();
    }
}
