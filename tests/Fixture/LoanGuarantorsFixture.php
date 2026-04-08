<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoanGuarantorsFixture
 */
class LoanGuarantorsFixture extends TestFixture
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
                'loan_application_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'national_id' => 'Lorem ipsum dolor sit amet',
                'relationship' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum dolor sit amet',
                'employer' => 'Lorem ipsum dolor sit amet',
                'monthly_income' => 1.5,
                'currency' => 'Lorem ip',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-04-07 19:36:13',
                'modified' => '2026-04-07 19:36:13',
            ],
        ];
        parent::init();
    }
}
