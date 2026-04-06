<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayrollRunsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayrollRunsTable Test Case
 */
class PayrollRunsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayrollRunsTable
     */
    protected $PayrollRuns;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PayrollRuns',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PayrollRuns') ? [] : ['className' => PayrollRunsTable::class];
        $this->PayrollRuns = $this->getTableLocator()->get('PayrollRuns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PayrollRuns);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PayrollRunsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
