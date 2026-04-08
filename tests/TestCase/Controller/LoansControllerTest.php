<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\LoansController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\LoansController Test Case
 *
 * @uses \App\Controller\LoansController
 */
class LoansControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Loans',
        'app.Companies',
        'app.LoanApplications',
        'app.LoanProducts',
        'app.DelinquencyFlags',
        'app.LoanDeductions',
        'app.LoanDisbursements',
        'app.LoanRepayments',
        'app.LoanRestructures',
        'app.LoanSchedules',
        'app.LoanWriteoffs',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\LoansController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\LoansController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\LoansController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\LoansController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\LoansController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
