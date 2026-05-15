<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SchFees Controller — DEPRECATED
 *
 * School fee payments are now handled by the Receipts (Accounts Receivable) module.
 * This controller redirects all traffic there to prevent duplicate entry.
 */
class SchFeesController extends AppController
{
    /**
     * Redirect every action to the Receipts module with an informational message.
     */
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Flash->set(
            __('The School Fees module has been replaced by <strong>Receipts</strong>. '
             . 'Please record fee payments there — it posts correctly to the Accounts Receivable ledger.'),
            ['element' => 'default', 'params' => ['class' => 'warning'], 'escape' => false]
        );
        $this->redirect(['controller' => 'Receipts', 'action' => 'index']);
    }

    // Stub actions required by CakePHP routing (execution never reaches them).
    public function index()  {}
    public function view($id = null) {}
    public function add()    {}
    public function edit($id = null) {}
    public function delete($id = null) {}
}
