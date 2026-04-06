<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BudgetsFixture
 */
class BudgetsFixture extends TestFixture
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
                'account_id' => 1,
                'company_id' => 1,
                'amount' => 1.5,
                'start_date' => '2026-04-01',
                'end_date' => '2026-04-01',
                'created' => '2026-04-01 14:38:58',
                'modified' => '2026-04-01 14:38:58',
            ],
        ];
        parent::init();
    }
}
