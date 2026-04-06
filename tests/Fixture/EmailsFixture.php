<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmailsFixture
 */
class EmailsFixture extends TestFixture
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
                'contact_id' => 1,
                'subject' => 'Lorem ipsum dolor sit amet',
                'emailto' => 'Lorem ipsum dolor sit amet',
                'emailfrom' => 'Lorem ipsum dolor sit amet',
                'company_id' => 1,
            ],
        ];
        parent::init();
    }
}
