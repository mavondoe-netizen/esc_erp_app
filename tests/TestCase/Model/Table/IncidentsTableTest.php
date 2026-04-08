<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IncidentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IncidentsTable Test Case
 */
class IncidentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IncidentsTable
     */
    protected $Incidents;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Incidents',
        'app.Companies',
        'app.LossEvents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Incidents') ? [] : ['className' => IncidentsTable::class];
        $this->Incidents = $this->getTableLocator()->get('Incidents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Incidents);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\IncidentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\IncidentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
