<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuditActionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuditActionsTable Test Case
 */
class AuditActionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AuditActionsTable
     */
    protected $AuditActions;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AuditActions',
        'app.Companies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AuditActions') ? [] : ['className' => AuditActionsTable::class];
        $this->AuditActions = $this->getTableLocator()->get('AuditActions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AuditActions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AuditActionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AuditActionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
