<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuditFindingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuditFindingsTable Test Case
 */
class AuditFindingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AuditFindingsTable
     */
    protected $AuditFindings;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AuditFindings',
        'app.Companies',
        'app.Audits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AuditFindings') ? [] : ['className' => AuditFindingsTable::class];
        $this->AuditFindings = $this->getTableLocator()->get('AuditFindings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AuditFindings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AuditFindingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AuditFindingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
