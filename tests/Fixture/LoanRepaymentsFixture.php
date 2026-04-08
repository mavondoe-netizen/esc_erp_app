<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoanRepaymentsFixture
 */
class LoanRepaymentsFixture extends TestFixture
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
                'client_id' => 1,
                'amount' => 1.5,
                'currency' => 'Lorem ip',
                'source' => 'Lorem ipsum dolor sit amet',
                'payment_date' => '2026-04-07',
                'penalty_paid' => 1.5,
                'interest_paid' => 1.5,
                'principal_paid' => 1.5,
                'reference' => 'Lorem ipsum dolor sit amet',
                'account_id' => 1,
                'processed_by' => 1,
                'allocation_json' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-04-07 19:30:15',
                'modified' => '2026-04-07 19:30:15',
            ],
        ];
        parent::init();
    }
}
