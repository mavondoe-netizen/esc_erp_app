<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TransactionsFixture
 */
class TransactionsFixture extends TestFixture
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
                'bank_transaction_id' => 1,
                'date' => '2026-04-05',
                'description' => 'Lorem ipsum dolor sit amet',
                'currency' => 'Lorem ipsum dolor sit amet',
                'amount' => 1,
                'zwg' => 1,
                'type' => 'Lorem ips',
                'account_id' => 1,
                'department_id' => 1,
                'building_id' => 1,
                'tenant_id' => 1,
                'supplier_id' => 1,
                'customer_id' => 1,
                'company_id' => 1,
                'payperiod_id' => 1,
                'bill_id' => 1,
                'invoice_id' => 1,
            ],
        ];
        parent::init();
    }
}
