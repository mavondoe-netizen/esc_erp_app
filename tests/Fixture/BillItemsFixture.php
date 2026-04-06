<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillItemsFixture
 */
class BillItemsFixture extends TestFixture
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
                'bill_id' => 1,
                'account_id' => 1,
                'quantity' => 1,
                'unit_price' => 1,
                'line_total' => 1,
            ],
        ];
        parent::init();
    }
}
