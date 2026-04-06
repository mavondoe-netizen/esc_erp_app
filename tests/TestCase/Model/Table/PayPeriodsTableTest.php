<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayPeriodsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayPeriodsTable Test Case
 */
class PayPeriodsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayPeriodsTable
     */
    protected $PayPeriods;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PayPeriods',
        'app.Payslips',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PayPeriods') ? [] : ['className' => PayPeriodsTable::class];
        $this->PayPeriods = $this->getTableLocator()->get('PayPeriods', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PayPeriods);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PayPeriodsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
