<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ZimraReconciliationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ZimraReconciliationsTable Test Case
 */
class ZimraReconciliationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ZimraReconciliationsTable
     */
    protected $ZimraReconciliations;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ZimraReconciliations',
        'app.Companies',
        'app.Employees',
        'app.PayPeriods',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ZimraReconciliations') ? [] : ['className' => ZimraReconciliationsTable::class];
        $this->ZimraReconciliations = $this->getTableLocator()->get('ZimraReconciliations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ZimraReconciliations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ZimraReconciliationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ZimraReconciliationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
