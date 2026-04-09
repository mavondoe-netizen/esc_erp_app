<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssetTransfersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetTransfersTable Test Case
 */
class AssetTransfersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetTransfersTable
     */
    protected $AssetTransfers;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AssetTransfers',
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
        $config = $this->getTableLocator()->exists('AssetTransfers') ? [] : ['className' => AssetTransfersTable::class];
        $this->AssetTransfers = $this->getTableLocator()->get('AssetTransfers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AssetTransfers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AssetTransfersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AssetTransfersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
