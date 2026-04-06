<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CreditNotesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CreditNotesTable Test Case
 */
class CreditNotesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CreditNotesTable
     */
    protected $CreditNotes;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.CreditNotes',
        'app.Companies',
        'app.Customers',
        'app.CreditNoteItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CreditNotes') ? [] : ['className' => CreditNotesTable::class];
        $this->CreditNotes = $this->getTableLocator()->get('CreditNotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CreditNotes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CreditNotesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CreditNotesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
