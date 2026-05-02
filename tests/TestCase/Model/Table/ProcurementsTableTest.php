<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProcurementsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProcurementsTable Test Case
 */
class ProcurementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProcurementsTable
     */
    protected $Procurements;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Procurements',
        'app.Requisitions',
        'app.Companies',
        'app.Tenders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Procurements') ? [] : ['className' => ProcurementsTable::class];
        $this->Procurements = $this->getTableLocator()->get('Procurements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Procurements);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ProcurementsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ProcurementsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
