<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayrollComponentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayrollComponentsTable Test Case
 */
class PayrollComponentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayrollComponentsTable
     */
    protected $PayrollComponents;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.PayrollComponents',
        'app.PayrollRecordItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PayrollComponents') ? [] : ['className' => PayrollComponentsTable::class];
        $this->PayrollComponents = $this->getTableLocator()->get('PayrollComponents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PayrollComponents);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PayrollComponentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
