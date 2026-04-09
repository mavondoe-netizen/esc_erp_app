<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssetsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetsTable Test Case
 */
class AssetsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetsTable
     */
    protected $Assets;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Assets',
        'app.Companies',
        'app.Offices',
        'app.AssetAssignments',
        'app.AssetDepreciation',
        'app.AssetDisposals',
        'app.AssetLogs',
        'app.AssetRepairs',
        'app.AssetTransfers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Assets') ? [] : ['className' => AssetsTable::class];
        $this->Assets = $this->getTableLocator()->get('Assets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Assets);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AssetsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AssetsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
