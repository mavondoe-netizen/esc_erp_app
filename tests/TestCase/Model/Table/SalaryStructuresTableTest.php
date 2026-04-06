<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SalaryStructuresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SalaryStructuresTable Test Case
 */
class SalaryStructuresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SalaryStructuresTable
     */
    protected $SalaryStructures;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.SalaryStructures',
        'app.Users',
        'app.Roles',
        'app.PayrollRecords',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SalaryStructures') ? [] : ['className' => SalaryStructuresTable::class];
        $this->SalaryStructures = $this->getTableLocator()->get('SalaryStructures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SalaryStructures);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SalaryStructuresTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SalaryStructuresTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
