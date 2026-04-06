<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenantsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenantsTable Test Case
 */
class TenantsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TenantsTable
     */
    protected $Tenants;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Tenants',
        'app.Contacts',
        'app.Enrolments',
        'app.Transactions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Tenants') ? [] : ['className' => TenantsTable::class];
        $this->Tenants = $this->getTableLocator()->get('Tenants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Tenants);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TenantsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\TenantsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
