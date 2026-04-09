<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetRepairsFixture
 */
class AssetRepairsFixture extends TestFixture
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
                'asset_id' => 1,
                'issue_description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'repair_type' => 'Lorem ipsum dolor sit amet',
                'vendor' => 'Lorem ipsum dolor sit amet',
                'cost' => 1.5,
                'start_date' => '2026-04-09',
                'end_date' => '2026-04-09',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-09 04:52:47',
                'modified' => '2026-04-09 04:52:47',
            ],
        ];
        parent::init();
    }
}
