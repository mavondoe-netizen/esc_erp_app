<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuditsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuditsTable Test Case
 */
class AuditsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AuditsTable
     */
    protected $Audits;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Audits',
        'app.Companies',
        'app.AuditPlans',
        'app.AuditFindings',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Audits') ? [] : ['className' => AuditsTable::class];
        $this->Audits = $this->getTableLocator()->get('Audits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Audits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AuditsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AuditsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
