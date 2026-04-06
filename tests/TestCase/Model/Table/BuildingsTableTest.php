<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BuildingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BuildingsTable Test Case
 */
class BuildingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BuildingsTable
     */
    protected $Buildings;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Buildings',
        'app.Investors',
        'app.Bills',
        'app.Transactions',
        'app.Units',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Buildings') ? [] : ['className' => BuildingsTable::class];
        $this->Buildings = $this->getTableLocator()->get('Buildings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Buildings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BuildingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\BuildingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
