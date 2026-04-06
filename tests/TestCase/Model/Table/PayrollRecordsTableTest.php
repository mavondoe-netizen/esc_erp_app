<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayrollRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayrollRecordsTable Test Case
 */
class PayrollRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayrollRecordsTable
     */
    protected $PayrollRecords;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PayrollRecords',
        'app.Users',
        'app.SalaryStructures',
        'app.PayrollRecordItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PayrollRecords') ? [] : ['className' => PayrollRecordsTable::class];
        $this->PayrollRecords = $this->getTableLocator()->get('PayrollRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PayrollRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PayrollRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PayrollRecordsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
