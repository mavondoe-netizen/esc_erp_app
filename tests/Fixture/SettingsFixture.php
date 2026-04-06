<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SettingsFixture
 */
class SettingsFixture extends TestFixture
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
                'nssa_ceiling' => 1.5,
                'nssa_rate' => 1.5,
                'created' => '2026-03-12 19:59:23',
                'modified' => '2026-03-12 19:59:23',
            ],
        ];
        parent::init();
    }
}
