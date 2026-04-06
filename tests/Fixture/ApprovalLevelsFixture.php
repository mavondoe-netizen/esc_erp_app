<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ApprovalLevelsFixture
 */
class ApprovalLevelsFixture extends TestFixture
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
                'entity' => 'Lorem ipsum dolor sit amet',
                'level' => 1,
                'role' => 'Lorem ipsum dolor sit amet',
                'min_value' => 1.5,
                'created' => '2025-10-19 15:30:46',
                'modified' => '2025-10-19 15:30:46',
            ],
        ];
        parent::init();
    }
}
