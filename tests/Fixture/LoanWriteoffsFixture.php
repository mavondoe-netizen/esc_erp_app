<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoanWriteoffsFixture
 */
class LoanWriteoffsFixture extends TestFixture
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
                'amount' => 1.5,
                'currency' => 'Lorem ip',
                'outstanding_at_writeoff' => 1.5,
                'reason' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => 'Lorem ipsum dolor sit amet',
                'approved_by' => 1,
                'approved_at' => '2026-04-07 19:35:57',
                'account_id' => 1,
                'created' => '2026-04-07 19:35:57',
                'modified' => '2026-04-07 19:35:57',
            ],
        ];
        parent::init();
    }
}
