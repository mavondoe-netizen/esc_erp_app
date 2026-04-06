<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MeetingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MeetingsTable Test Case
 */
class MeetingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MeetingsTable
     */
    protected $Meetings;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Meetings',
        'app.Contacts',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Meetings') ? [] : ['className' => MeetingsTable::class];
        $this->Meetings = $this->getTableLocator()->get('Meetings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Meetings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MeetingsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MeetingsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
