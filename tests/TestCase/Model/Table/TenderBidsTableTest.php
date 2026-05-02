<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenderBidsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenderBidsTable Test Case
 */
class TenderBidsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TenderBidsTable
     */
    protected $TenderBids;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.TenderBids',
        'app.Tenders',
        'app.Suppliers',
        'app.Companies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TenderBids') ? [] : ['className' => TenderBidsTable::class];
        $this->TenderBids = $this->getTableLocator()->get('TenderBids', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TenderBids);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TenderBidsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\TenderBidsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
