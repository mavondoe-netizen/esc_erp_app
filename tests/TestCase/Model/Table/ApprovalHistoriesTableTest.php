<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApprovalHistoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApprovalHistoriesTable Test Case
 */
class ApprovalHistoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ApprovalHistoriesTable
     */
    protected $ApprovalHistories;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ApprovalHistories',
        'app.Approvals',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ApprovalHistories') ? [] : ['className' => ApprovalHistoriesTable::class];
        $this->ApprovalHistories = $this->getTableLocator()->get('ApprovalHistories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ApprovalHistories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ApprovalHistoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ApprovalHistoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
