<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EventsFixture
 */
class EventsFixture extends TestFixture
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
                'created' => '2026-03-31 18:53:16',
                'modified' => '2026-03-31 18:53:16',
                'name' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
