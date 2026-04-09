<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetsFixture
 */
class AssetsFixture extends TestFixture
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
                'asset_tag' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'category_id' => 1,
                'classification_id' => 1,
                'acquisition_date' => '2026-04-09',
                'acquisition_cost' => 1.5,
                'useful_life' => 1,
                'depreciation_method' => 'Lorem ipsum dolor sit amet',
                'residual_value' => 1.5,
                'current_book_value' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'office_id' => 1,
                'assigned_to' => 1,
                'created' => '2026-04-09 04:52:29',
                'modified' => '2026-04-09 04:52:29',
            ],
        ];
        parent::init();
    }
}
