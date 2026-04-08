<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoanRestructuresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoanRestructuresTable Test Case
 */
class LoanRestructuresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoanRestructuresTable
     */
    protected $LoanRestructures;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LoanRestructures',
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
        $config = $this->getTableLocator()->exists('LoanRestructures') ? [] : ['className' => LoanRestructuresTable::class];
        $this->LoanRestructures = $this->getTableLocator()->get('LoanRestructures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoanRestructures);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoanRestructuresTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoanRestructuresTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
