<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvitationsFixture
 */
class InvitationsFixture extends TestFixture
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
                'email' => 'Lorem ipsum dolor sit amet',
                'company_id' => 1,
                'role_id' => 1,
                'token' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-01 03:18:15',
                'modified' => '2026-04-01 03:18:15',
            ],
        ];
        parent::init();
    }
}
