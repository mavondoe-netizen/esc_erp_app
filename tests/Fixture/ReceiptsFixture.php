<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ReceiptsFixture
 */
class ReceiptsFixture extends TestFixture
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
                'currency' => 'Lorem ipsum dolor sit amet',
                'amount' => 1,
                'account_id' => 1,
            ],
        ];
        parent::init();
    }
}
