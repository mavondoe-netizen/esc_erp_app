<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayrollRecordItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayrollRecordItemsTable Test Case
 */
class PayrollRecordItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayrollRecordItemsTable
     */
    protected $PayrollRecordItems;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PayrollRecordItems',
        'app.PayrollRecords',
        'app.PayrollComponents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PayrollRecordItems') ? [] : ['className' => PayrollRecordItemsTable::class];
        $this->PayrollRecordItems = $this->getTableLocator()->get('PayrollRecordItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PayrollRecordItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PayrollRecordItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PayrollRecordItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
