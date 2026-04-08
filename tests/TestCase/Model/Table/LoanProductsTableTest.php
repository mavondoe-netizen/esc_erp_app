<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoanProductsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoanProductsTable Test Case
 */
class LoanProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoanProductsTable
     */
    protected $LoanProducts;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LoanProducts',
        'app.Companies',
        'app.LoanApplications',
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
        $config = $this->getTableLocator()->exists('LoanProducts') ? [] : ['className' => LoanProductsTable::class];
        $this->LoanProducts = $this->getTableLocator()->get('LoanProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoanProducts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoanProductsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoanProductsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
