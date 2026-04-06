<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EstimateItemsFixture
 */
class EstimateItemsFixture extends TestFixture
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
                'estimate_id' => 1,
                'product_id' => 1,
                'account_id' => 1,
                'quantity' => 1.5,
                'unit_price' => 1.5,
                'line_total' => 1.5,
            ],
        ];
        parent::init();
    }
}
