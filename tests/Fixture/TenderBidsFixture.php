<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TenderBidsFixture
 */
class TenderBidsFixture extends TestFixture
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
                'bid_amount' => 1.5,
                'technical_score' => 1.5,
                'financial_score' => 1.5,
                'total_score' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'company_id' => 1,
                'created' => '2026-04-30 20:10:11',
                'modified' => '2026-04-30 20:10:11',
            ],
        ];
        parent::init();
    }
}
