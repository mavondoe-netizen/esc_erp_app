<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ModulesFixture
 */
class ModulesFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'model' => 'Lorem ipsum dolor sit amet',
                'is_active' => 1,
                'created' => '2026-03-29 13:02:17',
                'modified' => '2026-03-29 13:02:17',
                'company_id' => 1,
            ],
        ];
        parent::init();
    }
}
