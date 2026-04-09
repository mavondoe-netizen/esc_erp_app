<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetCategoriesFixture
 */
class AssetCategoriesFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'default_useful_life' => 1,
                'depreciation_method' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-09 04:52:16',
                'modified' => '2026-04-09 04:52:16',
            ],
        ];
        parent::init();
    }
}
