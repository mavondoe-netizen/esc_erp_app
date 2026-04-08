<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoanDisbursementsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoanDisbursementsTable Test Case
 */
class LoanDisbursementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoanDisbursementsTable
     */
    protected $LoanDisbursements;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LoanDisbursements',
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
        $config = $this->getTableLocator()->exists('LoanDisbursements') ? [] : ['className' => LoanDisbursementsTable::class];
        $this->LoanDisbursements = $this->getTableLocator()->get('LoanDisbursements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoanDisbursements);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoanDisbursementsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoanDisbursementsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
