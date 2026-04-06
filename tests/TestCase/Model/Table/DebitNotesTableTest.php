<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DebitNotesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DebitNotesTable Test Case
 */
class DebitNotesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DebitNotesTable
     */
    protected $DebitNotes;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.DebitNotes',
        'app.Companies',
        'app.Suppliers',
        'app.DebitNoteItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DebitNotes') ? [] : ['className' => DebitNotesTable::class];
        $this->DebitNotes = $this->getTableLocator()->get('DebitNotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DebitNotes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DebitNotesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DebitNotesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
