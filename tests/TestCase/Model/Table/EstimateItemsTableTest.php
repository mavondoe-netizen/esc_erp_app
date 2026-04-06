<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EstimateItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EstimateItemsTable Test Case
 */
class EstimateItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EstimateItemsTable
     */
    protected $EstimateItems;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.EstimateItems',
        'app.Estimates',
        'app.Products',
        'app.Accounts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EstimateItems') ? [] : ['className' => EstimateItemsTable::class];
        $this->EstimateItems = $this->getTableLocator()->get('EstimateItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EstimateItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EstimateItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\EstimateItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
