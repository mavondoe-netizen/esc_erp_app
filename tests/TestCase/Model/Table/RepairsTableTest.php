<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RepairsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RepairsTable Test Case
 */
class RepairsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RepairsTable
     */
    protected $Repairs;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Repairs',
        'app.Companies',
        'app.Units',
        'app.Buildings',
        'app.Tenants',
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
        $config = $this->getTableLocator()->exists('Repairs') ? [] : ['className' => RepairsTable::class];
        $this->Repairs = $this->getTableLocator()->get('Repairs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Repairs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RepairsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RepairsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
