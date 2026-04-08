<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuditPlansTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuditPlansTable Test Case
 */
class AuditPlansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AuditPlansTable
     */
    protected $AuditPlans;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AuditPlans',
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
        $config = $this->getTableLocator()->exists('AuditPlans') ? [] : ['className' => AuditPlansTable::class];
        $this->AuditPlans = $this->getTableLocator()->get('AuditPlans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AuditPlans);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AuditPlansTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AuditPlansTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
