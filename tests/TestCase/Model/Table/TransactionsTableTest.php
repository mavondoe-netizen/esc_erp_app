<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransactionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransactionsTable Test Case
 */
class TransactionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransactionsTable
     */
    protected $Transactions;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Transactions',
        'app.Accounts',
        'app.Departments',
        'app.Buildings',
        'app.Tenants',
        'app.Suppliers',
        'app.Customers',
        'app.Companies',
        'app.Payperiods',
        'app.BankTransactions',
        'app.Bills',
        'app.Invoices',
        'app.Receipts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Transactions') ? [] : ['className' => TransactionsTable::class];
        $this->Transactions = $this->getTableLocator()->get('Transactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Transactions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TransactionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\TransactionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
