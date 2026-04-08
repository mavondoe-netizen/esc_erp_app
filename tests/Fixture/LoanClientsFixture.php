<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LoanClientsFixture
 */
class LoanClientsFixture extends TestFixture
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
                'employee_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'national_id' => 'Lorem ipsum dolor sit amet',
                'dob' => '2026-04-07',
                'gender' => 'Lorem ipsum dolor ',
                'employer_name' => 'Lorem ipsum dolor sit amet',
                'employment_type' => 'Lorem ipsum dolor sit amet',
                'monthly_income' => 1.5,
                'income_currency' => 'Lorem ip',
                'contact_phone' => 'Lorem ipsum dolor sit amet',
                'contact_email' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => 'Lorem ipsum dolor sit amet',
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-04-07 19:19:33',
                'modified' => '2026-04-07 19:19:33',
            ],
        ];
        parent::init();
    }
}
