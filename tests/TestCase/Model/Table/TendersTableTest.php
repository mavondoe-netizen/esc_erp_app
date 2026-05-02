<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TendersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TendersTable Test Case
 */
class TendersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TendersTable
     */
    protected $Tenders;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Tenders',
        'app.Procurements',
        'app.Companies',
        'app.Awards',
        'app.Evaluations',
        'app.TenderBids',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Tenders') ? [] : ['className' => TendersTable::class];
        $this->Tenders = $this->getTableLocator()->get('Tenders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Tenders);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TendersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\TendersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
