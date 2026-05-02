<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsReceiptsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsReceiptsTable Test Case
 */
class GoodsReceiptsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsReceiptsTable
     */
    protected $GoodsReceipts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.GoodsReceipts',
        'app.Contracts',
        'app.Companies',
        'app.GoodsReceiptItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GoodsReceipts') ? [] : ['className' => GoodsReceiptsTable::class];
        $this->GoodsReceipts = $this->getTableLocator()->get('GoodsReceipts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->GoodsReceipts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\GoodsReceiptsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\GoodsReceiptsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
