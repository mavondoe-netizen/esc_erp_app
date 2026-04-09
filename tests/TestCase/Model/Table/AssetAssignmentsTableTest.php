<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssetAssignmentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetAssignmentsTable Test Case
 */
class AssetAssignmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetAssignmentsTable
     */
    protected $AssetAssignments;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.AssetAssignments',
        'app.Companies',
        'app.Assets',
        'app.Offices',
        'app.Departments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AssetAssignments') ? [] : ['className' => AssetAssignmentsTable::class];
        $this->AssetAssignments = $this->getTableLocator()->get('AssetAssignments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AssetAssignments);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AssetAssignmentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AssetAssignmentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
