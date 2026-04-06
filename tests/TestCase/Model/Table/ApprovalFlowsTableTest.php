<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApprovalFlowsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApprovalFlowsTable Test Case
 */
class ApprovalFlowsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ApprovalFlowsTable
     */
    protected $ApprovalFlows;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ApprovalFlows',
        'app.Roles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ApprovalFlows') ? [] : ['className' => ApprovalFlowsTable::class];
        $this->ApprovalFlows = $this->getTableLocator()->get('ApprovalFlows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ApprovalFlows);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ApprovalFlowsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ApprovalFlowsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
