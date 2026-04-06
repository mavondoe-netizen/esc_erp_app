<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ApprovalsFixture
 */
class ApprovalsFixture extends TestFixture
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
                'table_name' => 'Lorem ipsum dolor sit amet',
                'entity_id' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'initiated_by' => 1,
                'approved_by' => 1,
                'remarks' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2025-09-30 02:52:22',
                'approved_at' => '2025-09-30 02:52:22',
            ],
        ];
        parent::init();
    }
}
