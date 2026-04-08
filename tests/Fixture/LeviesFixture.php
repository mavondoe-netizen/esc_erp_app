<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LeviesFixture
 */
class LeviesFixture extends TestFixture
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
                'enrolment_id' => 1,
                'tenant_id' => 1,
                'unit_id' => 1,
                'building_id' => 1,
                'levy_type' => 'Lorem ipsum dolor sit amet',
                'amount' => 1.5,
                'currency' => 'Lorem ip',
                'due_date' => '2026-04-06',
                'paid' => 1,
                'paid_date' => '2026-04-06',
                'account_id' => 1,
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-04-06 18:36:33',
                'modified' => '2026-04-06 18:36:33',
            ],
        ];
        parent::init();
    }
}
