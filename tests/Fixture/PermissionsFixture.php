<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PermissionsFixture
 */
class PermissionsFixture extends TestFixture
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
                'role_id' => 1,
                'model' => 'Lorem ipsum dolor sit amet',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_approve' => 1,
                'created' => '2026-03-29 13:03:38',
                'modified' => '2026-03-29 13:03:38',
                'company_id' => 1,
            ],
        ];
        parent::init();
    }
}
