<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EarningsFixture
 */
class EarningsFixture extends TestFixture
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
                'taxable' => 1,
                'pensionable' => 1,
                'nssa_applicable' => 1,
                'calculation_type' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
