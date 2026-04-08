<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RiskAssessmentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RiskAssessmentsTable Test Case
 */
class RiskAssessmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RiskAssessmentsTable
     */
    protected $RiskAssessments;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.RiskAssessments',
        'app.Companies',
        'app.Risks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RiskAssessments') ? [] : ['className' => RiskAssessmentsTable::class];
        $this->RiskAssessments = $this->getTableLocator()->get('RiskAssessments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RiskAssessments);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RiskAssessmentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RiskAssessmentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
