<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DealRequestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DealRequestsTable Test Case
 */
class DealRequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DealRequestsTable
     */
    protected $DealRequests;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.DealRequests',
        'app.Companies',
        'app.Deals',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DealRequests') ? [] : ['className' => DealRequestsTable::class];
        $this->DealRequests = $this->getTableLocator()->get('DealRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DealRequests);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DealRequestsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DealRequestsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
