<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EarningsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EarningsTable Test Case
 */
class EarningsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EarningsTable
     */
    protected $Earnings;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Earnings',
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
        $config = $this->getTableLocator()->exists('Earnings') ? [] : ['className' => EarningsTable::class];
        $this->Earnings = $this->getTableLocator()->get('Earnings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Earnings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EarningsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\EarningsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
