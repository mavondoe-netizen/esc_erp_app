<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ComplianceChecksFixture
 */
class ComplianceChecksFixture extends TestFixture
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
                'obligation_id' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'evidence' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'checked_at' => '2026-04-08 16:36:50',
                'created' => '2026-04-08 16:36:50',
                'modified' => '2026-04-08 16:36:50',
            ],
        ];
        parent::init();
    }
}
