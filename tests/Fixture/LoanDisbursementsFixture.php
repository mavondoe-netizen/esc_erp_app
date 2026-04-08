<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoanDisbursementsFixture
 */
class LoanDisbursementsFixture extends TestFixture
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
                'method' => 'Lorem ipsum dolor sit amet',
                'bank_reference' => 'Lorem ipsum dolor sit amet',
                'account_id' => 1,
                'disbursed_by' => 1,
                'disbursed_at' => '2026-04-07 19:29:32',
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-04-07 19:29:32',
                'modified' => '2026-04-07 19:29:32',
            ],
        ];
        parent::init();
    }
}
