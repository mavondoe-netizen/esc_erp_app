<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RisksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RisksTable Test Case
 */
class RisksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RisksTable
     */
    protected $Risks;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Risks',
        'app.Companies',
        'app.Controls',
        'app.Kris',
        'app.RiskAssessments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Risks') ? [] : ['className' => RisksTable::class];
        $this->Risks = $this->getTableLocator()->get('Risks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Risks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RisksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\RisksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
