<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeviesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeviesTable Test Case
 */
class LeviesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LeviesTable
     */
    protected $Levies;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Levies',
        'app.Companies',
        'app.Enrolments',
        'app.Tenants',
        'app.Units',
        'app.Buildings',
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
        $config = $this->getTableLocator()->exists('Levies') ? [] : ['className' => LeviesTable::class];
        $this->Levies = $this->getTableLocator()->get('Levies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Levies);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LeviesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LeviesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
