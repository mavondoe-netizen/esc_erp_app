<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\KrisTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\KrisTable Test Case
 */
class KrisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\KrisTable
     */
    protected $Kris;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Kris',
        'app.Companies',
        'app.Risks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Kris') ? [] : ['className' => KrisTable::class];
        $this->Kris = $this->getTableLocator()->get('Kris', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Kris);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\KrisTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\KrisTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
