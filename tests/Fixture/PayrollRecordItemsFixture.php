<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PayrollRecordItemsFixture
 */
class PayrollRecordItemsFixture extends TestFixture
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
                'payroll_record_id' => 1,
                'payroll_component_id' => 1,
                'amount' => 1.5,
                'created' => '2026-03-07 09:19:23',
                'modified' => '2026-03-07 09:19:23',
            ],
        ];
        parent::init();
    }
}
