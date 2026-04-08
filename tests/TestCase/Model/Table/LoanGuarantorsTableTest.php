<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LoanGuarantorsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LoanGuarantorsTable Test Case
 */
class LoanGuarantorsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LoanGuarantorsTable
     */
    protected $LoanGuarantors;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LoanGuarantors',
        'app.LoanApplications',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LoanGuarantors') ? [] : ['className' => LoanGuarantorsTable::class];
        $this->LoanGuarantors = $this->getTableLocator()->get('LoanGuarantors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoanGuarantors);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LoanGuarantorsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LoanGuarantorsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
