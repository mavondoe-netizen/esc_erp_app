<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoanRepaymentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoanRepaymentsTable Test Case
 */
class LoanRepaymentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoanRepaymentsTable
     */
    protected $LoanRepayments;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LoanRepayments',
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
        $config = $this->getTableLocator()->exists('LoanRepayments') ? [] : ['className' => LoanRepaymentsTable::class];
        $this->LoanRepayments = $this->getTableLocator()->get('LoanRepayments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoanRepayments);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoanRepaymentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoanRepaymentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
