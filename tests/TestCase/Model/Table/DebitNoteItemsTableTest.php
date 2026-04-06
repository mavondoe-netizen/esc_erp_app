<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DebitNoteItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DebitNoteItemsTable Test Case
 */
class DebitNoteItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DebitNoteItemsTable
     */
    protected $DebitNoteItems;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.DebitNoteItems',
        'app.DebitNotes',
        'app.Products',
        'app.Accounts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DebitNoteItems') ? [] : ['className' => DebitNoteItemsTable::class];
        $this->DebitNoteItems = $this->getTableLocator()->get('DebitNoteItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DebitNoteItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DebitNoteItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DebitNoteItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
