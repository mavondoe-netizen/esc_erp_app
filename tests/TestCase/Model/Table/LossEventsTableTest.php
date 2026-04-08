<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LossEventsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LossEventsTable Test Case
 */
class LossEventsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LossEventsTable
     */
    protected $LossEvents;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.LossEvents',
        'app.Companies',
        'app.Incidents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LossEvents') ? [] : ['className' => LossEventsTable::class];
        $this->LossEvents = $this->getTableLocator()->get('LossEvents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LossEvents);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LossEventsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\LossEventsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
