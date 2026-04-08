<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComplianceChecksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ComplianceChecksTable Test Case
 */
class ComplianceChecksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ComplianceChecksTable
     */
    protected $ComplianceChecks;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ComplianceChecks',
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
        $config = $this->getTableLocator()->exists('ComplianceChecks') ? [] : ['className' => ComplianceChecksTable::class];
        $this->ComplianceChecks = $this->getTableLocator()->get('ComplianceChecks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ComplianceChecks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ComplianceChecksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ComplianceChecksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
