<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayslipItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayslipItemsTable Test Case
 */
class PayslipItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayslipItemsTable
     */
    protected $PayslipItems;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PayslipItems',
        'app.Payslips',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PayslipItems') ? [] : ['className' => PayslipItemsTable::class];
        $this->PayslipItems = $this->getTableLocator()->get('PayslipItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PayslipItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PayslipItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PayslipItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
