<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InspectionsFixture
 */
class InspectionsFixture extends TestFixture
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
                'customer_id' => 1,
                'date' => '2025-10-09',
                'pobs_insurable' => 1,
                'apwcs_insurable' => 1,
                'apwcs_penalty' => 1,
                'inspector_id' => 1,
            ],
        ];
        parent::init();
    }
}
