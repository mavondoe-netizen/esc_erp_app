<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RequisitionItemsFixture
 */
class RequisitionItemsFixture extends TestFixture
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
                'requisition_id' => 1,
                'item_description' => 'Lorem ipsum dolor sit amet',
                'quantity' => 1.5,
                'estimated_unit_price' => 1.5,
                'company_id' => 1,
                'created' => '2026-04-30 20:09:42',
                'modified' => '2026-04-30 20:09:42',
            ],
        ];
        parent::init();
    }
}
