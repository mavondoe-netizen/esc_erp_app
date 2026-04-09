<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssetLogsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetLogsTable Test Case
 */
class AssetLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetLogsTable
     */
    protected $AssetLogs;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AssetLogs',
        'app.Companies',
        'app.Assets',
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
        $config = $this->getTableLocator()->exists('AssetLogs') ? [] : ['className' => AssetLogsTable::class];
        $this->AssetLogs = $this->getTableLocator()->get('AssetLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AssetLogs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AssetLogsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AssetLogsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
