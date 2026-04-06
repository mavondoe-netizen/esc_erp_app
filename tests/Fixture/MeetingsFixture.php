<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MeetingsFixture
 */
class MeetingsFixture extends TestFixture
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
                'contact_id' => 1,
                'user_id' => 1,
                'agenda' => 'Lorem ipsum dolor sit amet',
                'outcomes' => 'Lorem ipsum dolor sit amet',
                'attachments' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
