<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetDisposalsFixture
 */
class AssetDisposalsFixture extends TestFixture
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
                'disposal_type' => 'Lorem ipsum dolor sit amet',
                'disposal_date' => '2026-04-09',
                'disposal_amount' => 1.5,
                'gain_or_loss' => 1.5,
                'approved_by' => 1,
                'created' => '2026-04-09 04:52:51',
                'modified' => '2026-04-09 04:52:51',
            ],
        ];
        parent::init();
    }
}
