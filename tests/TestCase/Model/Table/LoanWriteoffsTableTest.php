<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoanWriteoffsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoanWriteoffsTable Test Case
 */
class LoanWriteoffsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoanWriteoffsTable
     */
    protected $LoanWriteoffs;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LoanWriteoffs',
        'app.Loans',
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
        $config = $this->getTableLocator()->exists('LoanWriteoffs') ? [] : ['className' => LoanWriteoffsTable::class];
        $this->LoanWriteoffs = $this->getTableLocator()->get('LoanWriteoffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoanWriteoffs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoanWriteoffsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoanWriteoffsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
