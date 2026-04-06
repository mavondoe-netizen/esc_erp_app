<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeductionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeductionsTable Test Case
 */
class DeductionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DeductionsTable
     */
    protected $Deductions;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Deductions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Deductions') ? [] : ['className' => DeductionsTable::class];
        $this->Deductions = $this->getTableLocator()->get('Deductions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Deductions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DeductionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
