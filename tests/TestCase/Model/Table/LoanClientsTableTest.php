<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoanClientsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoanClientsTable Test Case
 */
class LoanClientsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoanClientsTable
     */
    protected $LoanClients;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LoanClients',
        'app.Companies',
        'app.Employees',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LoanClients') ? [] : ['className' => LoanClientsTable::class];
        $this->LoanClients = $this->getTableLocator()->get('LoanClients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoanClients);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoanClientsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoanClientsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
