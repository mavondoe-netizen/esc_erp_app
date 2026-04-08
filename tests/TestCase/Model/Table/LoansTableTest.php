<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoansTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoansTable Test Case
 */
class LoansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoansTable
     */
    protected $Loans;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Loans',
        'app.Companies',
        'app.LoanApplications',
        'app.LoanProducts',
        'app.DelinquencyFlags',
        'app.LoanDeductions',
        'app.LoanDisbursements',
        'app.LoanRepayments',
        'app.LoanRestructures',
        'app.LoanSchedules',
        'app.LoanWriteoffs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Loans') ? [] : ['className' => LoansTable::class];
        $this->Loans = $this->getTableLocator()->get('Loans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Loans);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoansTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoansTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
