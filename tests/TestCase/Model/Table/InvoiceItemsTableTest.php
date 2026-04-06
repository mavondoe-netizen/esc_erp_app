<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvoiceItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvoiceItemsTable Test Case
 */
class InvoiceItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InvoiceItemsTable
     */
    protected $InvoiceItems;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.InvoiceItems',
        'app.Invoices',
        'app.Accounts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('InvoiceItems') ? [] : ['className' => InvoiceItemsTable::class];
        $this->InvoiceItems = $this->getTableLocator()->get('InvoiceItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->InvoiceItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\InvoiceItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\InvoiceItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
