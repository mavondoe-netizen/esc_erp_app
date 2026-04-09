<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetDepreciationFixture
 */
class AssetDepreciationFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'asset_depreciation';
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
                'period' => 'Lorem ip',
                'depreciation_amount' => 1.5,
                'accumulated_depreciation' => 1.5,
                'book_value' => 1.5,
                'posted_to_ledger' => 1,
                'created' => '2026-04-09 04:52:34',
                'modified' => '2026-04-09 04:52:34',
            ],
        ];
        parent::init();
    }
}
