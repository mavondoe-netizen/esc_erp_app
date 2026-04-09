<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssetDepreciationTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetDepreciationTable Test Case
 */
class AssetDepreciationTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetDepreciationTable
     */
    protected $AssetDepreciation;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AssetDepreciation',
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
        $config = $this->getTableLocator()->exists('AssetDepreciation') ? [] : ['className' => AssetDepreciationTable::class];
        $this->AssetDepreciation = $this->getTableLocator()->get('AssetDepreciation', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AssetDepreciation);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AssetDepreciationTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AssetDepreciationTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
