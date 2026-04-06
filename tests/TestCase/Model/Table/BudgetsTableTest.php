<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BudgetsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BudgetsTable Test Case
 */
class BudgetsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BudgetsTable
     */
    protected $Budgets;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Budgets',
        'app.Accounts',
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
        $config = $this->getTableLocator()->exists('Budgets') ? [] : ['className' => BudgetsTable::class];
        $this->Budgets = $this->getTableLocator()->get('Budgets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Budgets);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BudgetsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\BudgetsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
