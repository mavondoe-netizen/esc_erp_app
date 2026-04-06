<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TaxTables;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TaxTables Test Case
 */
class TaxTablesTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TaxTables
     */
    protected $TaxTables;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Taxs') ? [] : ['className' => TaxTables::class];
        $this->TaxTables = $this->getTableLocator()->get('Taxs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TaxTables);

        parent::tearDown();
    }
}
