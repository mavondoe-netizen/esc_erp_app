<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayslipsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayslipsTable Test Case
 */
class PayslipsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayslipsTable
     */
    protected $Payslips;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Payslips',
        'app.Employees',
        'app.PayPeriods',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Payslips') ? [] : ['className' => PayslipsTable::class];
        $this->Payslips = $this->getTableLocator()->get('Payslips', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Payslips);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PayslipsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PayslipsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
