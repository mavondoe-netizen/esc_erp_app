<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PayrollComponentsFixture
 */
class PayrollComponentsFixture extends TestFixture
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
                'type' => 'Lorem ipsum dolor sit amet',
                'calculation_type' => 'Lorem ipsum dolor sit amet',
                'value' => 1.5,
                'is_statutory' => 1,
                'created' => '2026-03-07 09:13:29',
                'modified' => '2026-03-07 09:13:29',
            ],
        ];
        parent::init();
    }
}
