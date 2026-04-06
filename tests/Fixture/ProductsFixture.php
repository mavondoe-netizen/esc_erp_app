<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'account_id' => 1,
                'unit_price' => 1.5,
                'vat_rate' => 1.5,
                'created' => '2026-03-24 18:25:53',
                'modified' => '2026-03-24 18:25:53',
            ],
        ];
        parent::init();
    }
}
