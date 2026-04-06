<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TaxTablesFixture
 */
class TaxTablesFixture extends TestFixture
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
                'currency' => 'Lorem ipsum dolor sit amet',
                'lower_limit' => 1,
                'upper_limit' => 1,
                'rate' => 1,
                'deduction' => 1,
                'tax_year' => '2026-03-11',
            ],
        ];
        parent::init();
    }
}
