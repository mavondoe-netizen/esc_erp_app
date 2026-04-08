<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DelinquencyFlagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DelinquencyFlagsTable Test Case
 */
class DelinquencyFlagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DelinquencyFlagsTable
     */
    protected $DelinquencyFlags;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.DelinquencyFlags',
        'app.Loans',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DelinquencyFlags') ? [] : ['className' => DelinquencyFlagsTable::class];
        $this->DelinquencyFlags = $this->getTableLocator()->get('DelinquencyFlags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DelinquencyFlags);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DelinquencyFlagsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DelinquencyFlagsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
