<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoanSchedulesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoanSchedulesTable Test Case
 */
class LoanSchedulesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoanSchedulesTable
     */
    protected $LoanSchedules;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LoanSchedules',
        'app.Loans',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LoanSchedules') ? [] : ['className' => LoanSchedulesTable::class];
        $this->LoanSchedules = $this->getTableLocator()->get('LoanSchedules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoanSchedules);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoanSchedulesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoanSchedulesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
