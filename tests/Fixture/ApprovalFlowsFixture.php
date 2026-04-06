<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ApprovalFlowsFixture
 */
class ApprovalFlowsFixture extends TestFixture
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
                'module_name' => 'Lorem ipsum dolor sit amet',
                'level' => 1,
                'role_id' => 1,
                'description' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-10-28 17:04:24',
            ],
        ];
        parent::init();
    }
}
