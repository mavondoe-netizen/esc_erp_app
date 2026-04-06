<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LeaveApplicationsFixture
 */
class LeaveApplicationsFixture extends TestFixture
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
                'employee_id' => 1,
                'leave_type_id' => 1,
                'start_date' => '2026-03-15',
                'end_date' => '2026-03-15',
                'days_requested' => 1.5,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => 'Lorem ipsum dolor ',
                'created' => '2026-03-15 11:18:25',
                'modified' => '2026-03-15 11:18:25',
            ],
        ];
        parent::init();
    }
}
