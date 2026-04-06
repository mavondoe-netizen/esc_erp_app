<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DeductionsFixture
 */
class DeductionsFixture extends TestFixture
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
                'statutory' => 1,
                'tax_deductible' => 1,
                'calculation_type' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
