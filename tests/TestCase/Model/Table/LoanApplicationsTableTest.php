<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoanApplicationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoanApplicationsTable Test Case
 */
class LoanApplicationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoanApplicationsTable
     */
    protected $LoanApplications;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LoanApplications',
        'app.Companies',
        'app.LoanProducts',
        'app.LoanGuarantors',
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
        $config = $this->getTableLocator()->exists('LoanApplications') ? [] : ['className' => LoanApplicationsTable::class];
        $this->LoanApplications = $this->getTableLocator()->get('LoanApplications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoanApplications);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoanApplicationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoanApplicationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
