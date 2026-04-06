<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeaveBalancesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeaveBalancesTable Test Case
 */
class LeaveBalancesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LeaveBalancesTable
     */
    protected $LeaveBalances;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LeaveBalances',
        'app.Employees',
        'app.LeaveTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LeaveBalances') ? [] : ['className' => LeaveBalancesTable::class];
        $this->LeaveBalances = $this->getTableLocator()->get('LeaveBalances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LeaveBalances);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LeaveBalancesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LeaveBalancesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
