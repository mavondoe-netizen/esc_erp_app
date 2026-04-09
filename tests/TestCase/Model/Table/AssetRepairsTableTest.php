<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssetRepairsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetRepairsTable Test Case
 */
class AssetRepairsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetRepairsTable
     */
    protected $AssetRepairs;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AssetRepairs',
        'app.Companies',
        'app.Assets',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AssetRepairs') ? [] : ['className' => AssetRepairsTable::class];
        $this->AssetRepairs = $this->getTableLocator()->get('AssetRepairs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AssetRepairs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AssetRepairsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AssetRepairsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
