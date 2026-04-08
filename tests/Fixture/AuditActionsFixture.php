<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AuditActionsFixture
 */
class AuditActionsFixture extends TestFixture
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
                'finding_id' => 1,
                'assigned_to' => 1,
                'due_date' => '2026-04-08',
                'status' => 'Lorem ipsum dolor sit amet',
                'completion_date' => '2026-04-08',
                'created' => '2026-04-08 16:36:38',
                'modified' => '2026-04-08 16:36:38',
            ],
        ];
        parent::init();
    }
}
