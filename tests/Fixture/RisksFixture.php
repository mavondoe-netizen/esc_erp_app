<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RisksFixture
 */
class RisksFixture extends TestFixture
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
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'category' => 'Lorem ipsum dolor sit amet',
                'business_unit_id' => 1,
                'owner_id' => 1,
                'inherent_risk_score' => 1.5,
                'residual_risk_score' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-08 16:36:16',
                'modified' => '2026-04-08 16:36:16',
            ],
        ];
        parent::init();
    }
}
