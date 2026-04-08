<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * IncidentsFixture
 */
class IncidentsFixture extends TestFixture
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
                'company_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'type' => 'Lorem ipsum dolor sit amet',
                'business_unit_id' => 1,
                'reported_by' => 1,
                'reported_at' => '2026-04-08 16:36:55',
                'severity' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-08 16:36:55',
                'modified' => '2026-04-08 16:36:55',
            ],
        ];
        parent::init();
    }
}
