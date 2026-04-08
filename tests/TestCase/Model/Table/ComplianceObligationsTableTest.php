<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComplianceObligationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ComplianceObligationsTable Test Case
 */
class ComplianceObligationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ComplianceObligationsTable
     */
    protected $ComplianceObligations;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ComplianceObligations',
        'app.Companies',
        'app.Regulations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ComplianceObligations') ? [] : ['className' => ComplianceObligationsTable::class];
        $this->ComplianceObligations = $this->getTableLocator()->get('ComplianceObligations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ComplianceObligations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ComplianceObligationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ComplianceObligationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
