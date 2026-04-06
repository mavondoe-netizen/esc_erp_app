<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AuditTrailsFixture
 */
class AuditTrailsFixture extends TestFixture
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
                'entity_type' => 'Lorem ipsum dolor sit amet',
                'entity_id' => 1,
                'action' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'user_id' => 1,
                'created' => '2025-10-18 19:13:41',
            ],
        ];
        parent::init();
    }
}
