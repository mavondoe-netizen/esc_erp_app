<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegulationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegulationsTable Test Case
 */
class RegulationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RegulationsTable
     */
    protected $Regulations;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Regulations',
        'app.Companies',
        'app.ComplianceObligations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Regulations') ? [] : ['className' => RegulationsTable::class];
        $this->Regulations = $this->getTableLocator()->get('Regulations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Regulations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RegulationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RegulationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
