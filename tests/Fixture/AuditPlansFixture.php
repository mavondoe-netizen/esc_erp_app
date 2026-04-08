<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AuditPlansFixture
 */
class AuditPlansFixture extends TestFixture
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
                'year' => 1,
                'business_unit_id' => 1,
                'audit_type' => 'Lorem ipsum dolor sit amet',
                'planned_start' => '2026-04-08',
                'planned_end' => '2026-04-08',
                'created' => '2026-04-08 16:36:28',
                'modified' => '2026-04-08 16:36:28',
            ],
        ];
        parent::init();
    }
}
