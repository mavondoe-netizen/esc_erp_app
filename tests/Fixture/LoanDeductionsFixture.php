<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoanDeductionsFixture
 */
class LoanDeductionsFixture extends TestFixture
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
                'loan_id' => 1,
                'employee_id' => 1,
                'monthly_amount' => 1.5,
                'currency' => 'Lorem ip',
                'status' => 'Lorem ipsum dolor ',
                'start_date' => '2026-04-07',
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-04-07 19:34:55',
                'modified' => '2026-04-07 19:34:55',
            ],
        ];
        parent::init();
    }
}
