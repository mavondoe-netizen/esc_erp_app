<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoansFixture
 */
class LoansFixture extends TestFixture
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
                'client_id' => 1,
                'loan_application_id' => 1,
                'loan_product_id' => 1,
                'loan_account_no' => 'Lorem ipsum dolor sit amet',
                'principal' => 1.5,
                'outstanding_balance' => 1.5,
                'interest_rate' => 1.5,
                'interest_method' => 'Lorem ipsum dolor ',
                'repayment_frequency' => 'Lorem ipsum dolor ',
                'term' => 1,
                'currency' => 'Lorem ip',
                'start_date' => '2026-04-07',
                'maturity_date' => '2026-04-07',
                'disbursed_at' => '2026-04-07 19:20:14',
                'last_payment_date' => '2026-04-07',
                'status' => 'Lorem ipsum dolor sit amet',
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-04-07 19:20:14',
                'modified' => '2026-04-07 19:20:14',
            ],
        ];
        parent::init();
    }
}
