<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsReceiptItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsReceiptItemsTable Test Case
 */
class GoodsReceiptItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsReceiptItemsTable
     */
    protected $GoodsReceiptItems;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.GoodsReceiptItems',
        'app.GoodsReceipts',
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
        $config = $this->getTableLocator()->exists('GoodsReceiptItems') ? [] : ['className' => GoodsReceiptItemsTable::class];
        $this->GoodsReceiptItems = $this->getTableLocator()->get('GoodsReceiptItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->GoodsReceiptItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\GoodsReceiptItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\GoodsReceiptItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
