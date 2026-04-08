<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DelinquencyFlagsFixture
 */
class DelinquencyFlagsFixture extends TestFixture
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
                'days_overdue' => 1,
                'amount_overdue' => 1.5,
                'currency' => 'Lorem ip',
                'category' => 'Lorem ipsum dolor ',
                'flagged_at' => '2026-04-07 19:35:27',
                'resolved_at' => '2026-04-07 19:35:27',
                'notification_sent' => 1,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-04-07 19:35:27',
                'modified' => '2026-04-07 19:35:27',
            ],
        ];
        parent::init();
    }
}
