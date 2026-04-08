<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoanSchedulesFixture
 */
class LoanSchedulesFixture extends TestFixture
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
                'loan_id' => 1,
                'period_number' => 1,
                'due_date' => '2026-04-07',
                'principal_due' => 1.5,
                'interest_due' => 1.5,
                'penalty_due' => 1.5,
                'total_due' => 1.5,
                'amount_paid' => 1.5,
                'balance' => 1.5,
                'currency' => 'Lorem ip',
                'status' => 'Lorem ipsum dolor ',
                'created' => '2026-04-07 19:29:13',
                'modified' => '2026-04-07 19:29:13',
            ],
        ];
        parent::init();
    }
}
