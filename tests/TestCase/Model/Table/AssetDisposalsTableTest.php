<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssetDisposalsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetDisposalsTable Test Case
 */
class AssetDisposalsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetDisposalsTable
     */
    protected $AssetDisposals;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AssetDisposals',
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
        $config = $this->getTableLocator()->exists('AssetDisposals') ? [] : ['className' => AssetDisposalsTable::class];
        $this->AssetDisposals = $this->getTableLocator()->get('AssetDisposals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AssetDisposals);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AssetDisposalsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AssetDisposalsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
