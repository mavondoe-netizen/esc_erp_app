<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetTransfersFixture
 */
class AssetTransfersFixture extends TestFixture
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
                'from_office_id' => 1,
                'to_office_id' => 1,
                'transfer_date' => '2026-04-09',
                'approved_by' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-09 04:52:42',
                'modified' => '2026-04-09 04:52:42',
            ],
        ];
        parent::init();
    }
}
