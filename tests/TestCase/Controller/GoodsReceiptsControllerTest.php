<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\GoodsReceiptsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\GoodsReceiptsController Test Case
 *
 * @link \App\Controller\GoodsReceiptsController
 */
class GoodsReceiptsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.GoodsReceipts',
        'app.Contracts',
        'app.Users',
        'app.Companies',
        'app.GoodsReceiptItems',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\GoodsReceiptsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\GoodsReceiptsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\GoodsReceiptsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\GoodsReceiptsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\GoodsReceiptsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
