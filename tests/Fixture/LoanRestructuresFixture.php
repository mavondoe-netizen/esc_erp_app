<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoanRestructuresFixture
 */
class LoanRestructuresFixture extends TestFixture
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
                'old_term' => 1,
                'new_term' => 1,
                'old_rate' => 1.5,
                'new_rate' => 1.5,
                'outstanding_at_restructure' => 1.5,
                'reason' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => 'Lorem ipsum dolor sit amet',
                'approved_by' => 1,
                'approved_at' => '2026-04-07 19:35:44',
                'effective_date' => '2026-04-07',
                'created' => '2026-04-07 19:35:44',
                'modified' => '2026-04-07 19:35:44',
            ],
        ];
        parent::init();
    }
}
