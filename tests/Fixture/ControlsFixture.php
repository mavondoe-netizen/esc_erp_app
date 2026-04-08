<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControlsFixture
 */
class ControlsFixture extends TestFixture
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
                'risk_id' => 1,
                'control_name' => 'Lorem ipsum dolor sit amet',
                'control_type' => 'Lorem ipsum dolor sit amet',
                'frequency' => 'Lorem ipsum dolor sit amet',
                'owner_id' => 1,
                'effectiveness_rating' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-08 16:37:02',
                'modified' => '2026-04-08 16:37:02',
            ],
        ];
        parent::init();
    }
}
