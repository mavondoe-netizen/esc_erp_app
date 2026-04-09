<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OfficesFixture
 */
class OfficesFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'location' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-09 04:52:25',
                'modified' => '2026-04-09 04:52:25',
            ],
        ];
        parent::init();
    }
}
