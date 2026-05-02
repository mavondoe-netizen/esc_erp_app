<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProcurementsFixture
 */
class ProcurementsFixture extends TestFixture
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
                'requisition_id' => 1,
                'procurement_method' => 'Lorem ipsum dolor sit amet',
                'assigned_to' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'company_id' => 1,
                'created' => '2026-04-30 20:09:50',
                'modified' => '2026-04-30 20:09:50',
            ],
        ];
        parent::init();
    }
}
