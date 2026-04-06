<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DebitNotesFixture
 */
class DebitNotesFixture extends TestFixture
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
                'company_id' => 1,
                'supplier_id' => 1,
                'date' => '2026-04-03',
                'description' => 'Lorem ipsum dolor sit amet',
                'total' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-03 04:02:25',
                'modified' => '2026-04-03 04:02:25',
            ],
        ];
        parent::init();
    }
}
