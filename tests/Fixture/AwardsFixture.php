<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AwardsFixture
 */
class AwardsFixture extends TestFixture
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
                'tender_id' => 1,
                'supplier_id' => 1,
                'awarded_amount' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'company_id' => 1,
                'created' => '2026-04-30 20:10:35',
                'modified' => '2026-04-30 20:10:35',
            ],
        ];
        parent::init();
    }
}
