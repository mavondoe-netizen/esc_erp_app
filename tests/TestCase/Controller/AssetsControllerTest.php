<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AssetsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AssetsController Test Case
 *
 * @uses \App\Controller\AssetsController
 */
class AssetsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Assets',
        'app.Companies',
        'app.Offices',
        'app.AssetAssignments',
        'app.AssetDepreciation',
        'app.AssetDisposals',
        'app.AssetLogs',
        'app.AssetRepairs',
        'app.AssetTransfers',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AssetsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\AssetsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AssetsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AssetsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\AssetsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
