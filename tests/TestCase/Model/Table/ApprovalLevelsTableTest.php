<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApprovalLevelsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApprovalLevelsTable Test Case
 */
class ApprovalLevelsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ApprovalLevelsTable
     */
    protected $ApprovalLevels;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ApprovalLevels',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ApprovalLevels') ? [] : ['className' => ApprovalLevelsTable::class];
        $this->ApprovalLevels = $this->getTableLocator()->get('ApprovalLevels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ApprovalLevels);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ApprovalLevelsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
