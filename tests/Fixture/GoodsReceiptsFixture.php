<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GoodsReceiptsFixture
 */
class GoodsReceiptsFixture extends TestFixture
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
                'contract_id' => 1,
                'received_by' => 1,
                'received_date' => '2026-04-30 20:10:50',
                'status' => 'Lorem ipsum dolor sit amet',
                'company_id' => 1,
                'created' => '2026-04-30 20:10:50',
                'modified' => '2026-04-30 20:10:50',
            ],
        ];
        parent::init();
    }
}
