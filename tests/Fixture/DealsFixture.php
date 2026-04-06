<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DealsFixture
 */
class DealsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'date' => '2026-03-31',
                'type' => 'Lorem ipsum dolor sit amet',
                'value' => 1.5,
                'stage' => 'Lorem ipsum dolor sit amet',
                'contact_id' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'submitted_by' => 1,
                'submitted_at' => '2026-03-31 18:48:33',
                'approved_by' => 1,
                'approved_at' => '2026-03-31 18:48:33',
                'rejected_by' => 1,
                'rejected_at' => '2026-03-31 18:48:33',
                'rejection_reason' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'company_id' => 1,
            ],
        ];
        parent::init();
    }
}
