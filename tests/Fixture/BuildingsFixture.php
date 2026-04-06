<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BuildingsFixture
 */
class BuildingsFixture extends TestFixture
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
                'address' => 'Lorem ipsum dolor sit amet',
                'investor_id' => 1,
                'start_date' => '2025-09-21 12:22:07',
                'isvacant' => 1,
            ],
        ];
        parent::init();
    }
}
