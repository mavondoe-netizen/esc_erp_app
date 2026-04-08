<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoanProductsFixture
 */
class LoanProductsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'code' => 'Lorem ipsum dolor sit amet',
                'interest_rate' => 1.5,
                'interest_method' => 'Lorem ipsum dolor ',
                'repayment_frequency' => 'Lorem ipsum dolor ',
                'min_amount' => 1.5,
                'max_amount' => 1.5,
                'max_term' => 1,
                'min_term' => 1,
                'grace_period_days' => 1,
                'penalty_rate' => 1.5,
                'requires_guarantor' => 1,
                'currency' => 'Lorem ip',
                'is_active' => 1,
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-04-07 19:14:36',
                'modified' => '2026-04-07 19:14:36',
            ],
        ];
        parent::init();
    }
}
