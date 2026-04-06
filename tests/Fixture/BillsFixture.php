<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillsFixture
 */
class BillsFixture extends TestFixture
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
                'supplier_id' => 1,
                'date' => '2025-09-27',
                'description' => 'Lorem ipsum dolor sit amet',
                'currency' => 'Lorem ipsum dolor sit amet',
                'total' => 1,
            ],
        ];
        parent::init();
    }
}
