<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssetAssignmentsFixture
 */
class AssetAssignmentsFixture extends TestFixture
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
                'asset_id' => 1,
                'office_id' => 1,
                'department_id' => 1,
                'assigned_to' => 1,
                'assigned_date' => '2026-04-09',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-09 04:52:38',
                'modified' => '2026-04-09 04:52:38',
            ],
        ];
        parent::init();
    }
}
