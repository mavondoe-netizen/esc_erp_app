<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssetClassificationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetClassificationsTable Test Case
 */
class AssetClassificationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetClassificationsTable
     */
    protected $AssetClassifications;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AssetClassifications',
        'app.Companies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AssetClassifications') ? [] : ['className' => AssetClassificationsTable::class];
        $this->AssetClassifications = $this->getTableLocator()->get('AssetClassifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AssetClassifications);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AssetClassificationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AssetClassificationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
