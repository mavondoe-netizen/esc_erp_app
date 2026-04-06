<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstimatesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstimatesTable Test Case
 */
class EstimatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstimatesTable
     */
    protected $Estimates;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Estimates',
        'app.Companies',
        'app.Customers',
        'app.EstimateItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Estimates') ? [] : ['className' => EstimatesTable::class];
        $this->Estimates = $this->getTableLocator()->get('Estimates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Estimates);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EstimatesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\EstimatesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
