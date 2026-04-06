<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeeProfilesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeeProfilesTable Test Case
 */
class EmployeeProfilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeeProfilesTable
     */
    protected $EmployeeProfiles;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.EmployeeProfiles',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EmployeeProfiles') ? [] : ['className' => EmployeeProfilesTable::class];
        $this->EmployeeProfiles = $this->getTableLocator()->get('EmployeeProfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EmployeeProfiles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EmployeeProfilesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\EmployeeProfilesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
