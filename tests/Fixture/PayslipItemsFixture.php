<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PayslipItemsFixture
 */
class PayslipItemsFixture extends TestFixture
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
                'payslip_id' => 1,
                'item_type' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'amount' => 1.5,
            ],
        ];
        parent::init();
    }
}
