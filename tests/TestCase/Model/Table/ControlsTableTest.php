<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControlsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControlsTable Test Case
 */
class ControlsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ControlsTable
     */
    protected $Controls;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Controls',
        'app.Companies',
        'app.Risks',
        'app.ControlTests',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Controls') ? [] : ['className' => ControlsTable::class];
        $this->Controls = $this->getTableLocator()->get('Controls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Controls);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ControlsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ControlsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
