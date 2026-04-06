<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CreditNoteItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CreditNoteItemsTable Test Case
 */
class CreditNoteItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CreditNoteItemsTable
     */
    protected $CreditNoteItems;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CreditNoteItems',
        'app.CreditNotes',
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
        $config = $this->getTableLocator()->exists('CreditNoteItems') ? [] : ['className' => CreditNoteItemsTable::class];
        $this->CreditNoteItems = $this->getTableLocator()->get('CreditNoteItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CreditNoteItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CreditNoteItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CreditNoteItemsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
