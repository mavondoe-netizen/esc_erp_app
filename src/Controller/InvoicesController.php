<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Mailer\MailerAwareTrait;

/**
 * Invoices Controller
 *
 * Sales invoices — CRUD, line-item management, and ledger posting.
 * Implements a "post-once" guard: ledger entries are only created on first
 * save (status change to "Sent"/"Posted") and never duplicated on edit.
 */
class InvoicesController extends AppController
{
    use MailerAwareTrait;
    // -----------------------------------------------------------------------
    // INDEX
    // -----------------------------------------------------------------------

    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Invoices = $this->fetchTable('Invoices');

        $conditions = ['Invoices.company_id' => $companyId];

        // Simple filters
        $status   = $this->request->getQuery('status');
        $from     = $this->request->getQuery('start_date');
        $to       = $this->request->getQuery('end_date');
        $contactId = $this->request->getQuery('contact_id'); // Changed from customer_id

        if ($status)   $conditions['Invoices.status']      = $status;
        if ($from)     $conditions['Invoices.date >=']     = $from;
        if ($to)       $conditions['Invoices.date <=']     = $to;
        
        if ($contactId) {
            // Find the customer linked to this contact
            $customer = $this->fetchTable('Customers')->find()
                ->where(['contact_id' => $contactId])
                ->first();
            $conditions['Invoices.customer_id'] = $customer ? $customer->id : -1;
        }

        $query = $Invoices->find()
            ->where($conditions)
            ->contain(['Customers'])
            ->order(['Invoices.date' => 'DESC', 'Invoices.id' => 'DESC']);

        $invoices = $this->paginate($query, ['limit' => 50]);

        [$customers, $accounts] = $this->_dropdowns($companyId); // This returns Contacts as keys

        $this->set(compact('invoices', 'customers'));
    }

    // -----------------------------------------------------------------------
    // VIEW
    // -----------------------------------------------------------------------

    public function view(int $id)
    {
        $this->viewBuilder()->setLayout('document');
        $companyId = $this->request->getAttribute('company_id');

        $invoice = $this->fetchTable('Invoices')
            ->get($id, contain: ['Customers', 'InvoiceItems' => ['Accounts', 'Products'], 'Transactions' => ['Accounts']]);

        $company = $this->fetchTable('Companies')->get($companyId);

        $this->set(compact('invoice', 'company'));
    }

    // -----------------------------------------------------------------------
    // ADD
    // -----------------------------------------------------------------------

    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Invoices = $this->fetchTable('Invoices');
        $invoice  = $Invoices->newEmptyEntity();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['company_id'] = $companyId;
            $data['status']     = $data['status'] ?? 'Draft';

            // Automatic Customer Creation/Selection from Contact ID
            if (!empty($data['customer_id'])) {
                $data['customer_id'] = $this->_ensureCustomerFromContact((int)$data['customer_id'], $companyId);
            }

            $invoice = $Invoices->patchEntity($invoice, $data, [
                'associated' => ['InvoiceItems'],
            ]);

            if ($this->request->getQuery('popup')) {
                if ($Invoices->save($invoice)) {
                    $this->set('popupResult', ['id' => $invoice->id, 'name' => $invoice->reference ?? "INV-{$invoice->id}"]);
                    $this->viewBuilder()->disableAutoLayout();
                    return $this->render('/Element/popup_success');
                }
            }

            if ($Invoices->save($invoice)) {
                // Post ledger entries if status is Approved, Sent, or Paid
                if (in_array($invoice->status, ['Approved', 'Sent', 'Paid'])) {
                    $Invoices->postToLedger($invoice, $companyId);
                }
                $this->Flash->success(__('Invoice saved.'));
                
                // Send email if status is Sent
                if ($invoice->status === 'Sent') {
                    $this->_sendInvoiceEmail($invoice->id);
                }
                
                return $this->redirect(['action' => 'view', $invoice->id]);
            }
            $this->Flash->error(__('Could not save invoice.'));
        }

        [$customers, $accounts] = $this->_dropdowns($companyId);

        $products = $this->fetchTable('Products')->find()
            ->where(['Products.company_id' => $companyId])
            ->all();

        $productsOptions = [];
        $productsJson = [];
        foreach ($products as $p) {
            $productsOptions[$p->id] = $p->name;
            $productsJson[$p->id] = [
                'unit_price' => (float)$p->unit_price,
                'account_id' => $p->account_id,
                'vat_rate'   => (float)$p->vat_rate,
                'hs_code'    => $p->hs_code,
                'vat_type'   => $p->vat_type ?: 'Standard'
            ];
        }

        $this->set(compact('invoice', 'customers', 'accounts', 'productsOptions', 'productsJson'));
    }

    // -----------------------------------------------------------------------
    // EDIT
    // -----------------------------------------------------------------------

    public function edit(int $id)
    {
        $user      = $this->Authentication->getIdentity();
        $companyId = $user->get('company_id');

        $Invoices = $this->fetchTable('Invoices');
        $invoice  = $Invoices->get($id, contain: ['InvoiceItems']);

        $wasPosted = !in_array($invoice->status ?? 'Draft', ['Draft']);

        if ($this->request->is(['post', 'put'])) {
            $data      = $this->request->getData();
            $newStatus = $data['status'] ?? $invoice->status;

            // Automatic Customer Creation/Selection from Contact ID
            if (!empty($data['customer_id'])) {
                $data['customer_id'] = $this->_ensureCustomerFromContact((int)$data['customer_id'], $companyId);
            }

            $invoice   = $Invoices->patchEntity($invoice, $data, [
                'associated' => ['InvoiceItems'],
            ]);

            if ($Invoices->save($invoice)) {
                // Always reverse previous transactions to ensure the ledger is in sync
                $Invoices->reverseLedger($invoice->id, $companyId);

                // Re-post to ledger if status is Approved, Sent, or Paid
                if (in_array($newStatus, ['Approved', 'Sent', 'Paid'])) {
                    $Invoices->postToLedger($invoice, $companyId);
                }

                $this->Flash->success(__('Invoice updated.'));

                // Send email if status is changed to Sent
                if ($invoice->status === 'Sent') {
                    $this->_sendInvoiceEmail($invoice->id);
                }

                return $this->redirect(['action' => 'view', $invoice->id]);
            }

            $this->Flash->error(__('Could not update invoice.'));
        }

        [$customers, $accounts] = $this->_dropdowns($companyId);
        
        $products = $this->fetchTable('Products')->find()
            ->where(['Products.company_id' => $companyId])
            ->all();

        $productsOptions = [];
        $productsJson = [];
        foreach ($products as $p) {
            $productsOptions[$p->id] = $p->name;
            $productsJson[$p->id] = [
                'unit_price' => (float)$p->unit_price,
                'account_id' => $p->account_id,
                'vat_rate'   => (float)$p->vat_rate,
                'hs_code'    => $p->hs_code,
                'vat_type'   => $p->vat_type ?: 'Standard'
            ];
        }

        $currentContactId = null;
        if ($invoice->customer_id) {
            $customer = $this->fetchTable('Customers')->get($invoice->customer_id);
            $currentContactId = $customer->contact_id;
            
            // Override the entity value so FormHelper correctly pre-selects the contact
            if (!$this->request->is(['post', 'put'])) {
                $invoice->customer_id = $currentContactId;
            }
        }

        $this->set(compact('invoice', 'customers', 'accounts', 'productsOptions', 'productsJson', 'currentContactId'));
    }

    // -----------------------------------------------------------------------
    // REQUEST APPROVAL
    // -----------------------------------------------------------------------

    public function requestForApproval(int $id)
    {
        $this->request->allowMethod(['post', 'put']);
        $companyId = $this->request->getAttribute('company_id');
        
        $Invoices = $this->fetchTable('Invoices');
        $invoice = $Invoices->find()
            ->where(['Invoices.id' => $id, 'Invoices.company_id' => $companyId])
            ->first();

        if (!$invoice) {
            $this->Flash->error(__('Invoice not found.'));
            return $this->redirect(['action' => 'index']);
        }

        $invoice->status = 'Pending Approval';
        if ($Invoices->save($invoice)) {
            $workflow = new \App\Service\WorkflowService();
            $userId = clone $this->Authentication->getIdentity();
            $workflow->submitForApproval('Invoices', $invoice->id, $userId->getIdentifier());
            
            $this->Flash->success(__('The invoice has been submitted for approval.'));
        } else {
            $this->Flash->error(__('The invoice could not be submitted. Please, try again.'));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function approve(int $id)
    {
        $this->request->allowMethod(['post', 'put']);
        $companyId = $this->request->getAttribute('company_id');
        
        $Invoices = $this->fetchTable('Invoices');
        $invoice = $Invoices->find()
            ->where(['Invoices.id' => $id, 'Invoices.company_id' => $companyId])
            ->first();

        if (!$invoice) {
            $this->Flash->error(__('Invoice not found.'));
            return $this->redirect(['action' => 'index']);
        }

        $invoice->status = 'Approved';
        if ($Invoices->save($invoice)) {
            $Invoices->postToLedger($invoice, $companyId);
            
            // Sync with Approvals table if exists
            $Approvals = $this->fetchTable('Approvals');
            $approval = $Approvals->find()->where(['table_name' => 'Invoices', 'entity_id' => $id, 'status' => 'Pending'])->first();
            if ($approval) {
                $approval->status = 'Approved';
                $Approvals->save($approval);
            }
            
            $this->Flash->success(__('The invoice has been approved.'));
        } else {
            $this->Flash->error(__('The invoice could not be approved. Please, try again.'));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function reject(int $id)
    {
        $this->request->allowMethod(['post', 'put']);
        $companyId = $this->request->getAttribute('company_id');
        
        $Invoices = $this->fetchTable('Invoices');
        $invoice = $Invoices->find()
            ->where(['Invoices.id' => $id, 'Invoices.company_id' => $companyId])
            ->first();

        if (!$invoice) {
            $this->Flash->error(__('Invoice not found.'));
            return $this->redirect(['action' => 'index']);
        }

        $invoice->status = 'Rejected';
        if ($Invoices->save($invoice)) {
            // Sync with Approvals table if exists
            $Approvals = $this->fetchTable('Approvals');
            $approval = $Approvals->find()->where(['table_name' => 'Invoices', 'entity_id' => $id, 'status' => 'Pending'])->first();
            if ($approval) {
                $approval->status = 'Rejected';
                $Approvals->save($approval);
            }
            
            $this->Flash->success(__('The invoice has been rejected.'));
        } else {
            $this->Flash->error(__('The invoice could not be rejected. Please, try again.'));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }

    // -----------------------------------------------------------------------
    // DELETE
    // -----------------------------------------------------------------------

    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user      = $this->Authentication->getIdentity();
        $companyId = $user->get('company_id');

        $Invoices = $this->fetchTable('Invoices');
        $invoice  = $Invoices->find()
            ->where(['Invoices.id' => $id, 'Invoices.company_id' => $companyId])
            ->first();

        if (!$invoice) {
            $this->Flash->error(__('Invoice not found.'));
            return $this->redirect(['action' => 'index']);
        }

        // Reverse any ledger entries associated with this invoice
        $Invoices->reverseLedger($invoice->id, $companyId);

        if ($Invoices->delete($invoice)) {
            // Delete associated Approvals to prevent orphans
            $Approvals = $this->fetchTable('Approvals');
            $Approvals->deleteAll(['table_name' => 'Invoices', 'entity_id' => $invoice->id]);

            $this->Flash->success(__('Invoice deleted.'));
        } else {
            $this->Flash->error(__('Could not delete invoice.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // -----------------------------------------------------------------------
    // MARK PAID
    // -----------------------------------------------------------------------

    /**
     * Mark an invoice as paid and record a receipt.
     */
    public function markPaid(int $id)
    {
        $this->request->allowMethod(['post']);
        $companyId = $this->request->getAttribute('company_id');

        $Invoices = $this->fetchTable('Invoices');
        $invoice  = $Invoices->find()
            ->where(['Invoices.id' => $id, 'Invoices.company_id' => $companyId])
            ->first();

        if (!$invoice) {
            $this->Flash->error('Invoice not found.');
            return $this->redirect(['action' => 'index']);
        }

        $invoice->status = 'Paid';
        if ($Invoices->save($invoice)) {
            $paymentAccountId = $this->request->getData('payment_account_id');
            if ($paymentAccountId) {
                $Invoices->postPaymentToLedger($invoice, (int)$paymentAccountId, $companyId);
            }
            $this->Flash->success('Invoice marked as paid.');
        } else {
            $this->Flash->error('Could not update invoice status.');
        }

        return $this->redirect(['action' => 'view', $id]);
    }

    // -----------------------------------------------------------------------
    // PRIVATE — HELPER TO ENSURE CUSTOMER EXISTS FOR A CONTACT
    // -----------------------------------------------------------------------

    /**
     * Finds or creates a Customer record linked to the given Contact.
     */
    private function _ensureCustomerFromContact(int $contactId, int $companyId): int
    {
        $Customers = $this->fetchTable('Customers');
        $customer = $Customers->find()
            ->where(['Customers.contact_id' => $contactId, 'Customers.company_id' => $companyId])
            ->first();

        if ($customer) {
            return $customer->id;
        }

        // Create new Customer
        $Contact = $this->fetchTable('Contacts')->get($contactId);
        $newCustomer = $Customers->newEntity([
            'name' => $Contact->name,
            'address' => 'Auto-created from Contact',
            'contact_id' => $Contact->id,
            'company_id' => $companyId,
        ]);

        if ($Customers->save($newCustomer)) {
            return $newCustomer->id;
        }

        throw new \Exception("Could not auto-create customer for contact #$contactId");
    }

    // -----------------------------------------------------------------------
    // SHARED DROPDOWN HELPER — NOW RETURNS CONTACTS
    // -----------------------------------------------------------------------

    private function _dropdowns(int $companyId): array
    {
        // We now fetch Contacts instead of Customers because "all contacts are potentially customers"
        $customers = $this->fetchTable('Contacts')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Contacts.company_id' => $companyId])
            ->order(['Contacts.name' => 'ASC'])
            ->all();

        $accounts = $this->fetchTable('Accounts')
            ->find('list', keyField: 'id', valueField: 'name')
            ->where(['Accounts.company_id' => $companyId])
            ->order(['Accounts.type', 'Accounts.name'])
            ->all();

        return [$customers, $accounts];
    }

    /**
     * Helper to send invoice email
     */
    private function _sendInvoiceEmail(int $id): void
    {
        try {
            $invoice = $this->fetchTable('Invoices')->get($id, contain: ['Customers' => ['Contacts']]);
            $email = $invoice->customer->contact->email ?? null;

            if ($email) {
                $this->getMailer('Notification')->send('invoice', [$invoice->toArray(), $email]);
            }
        } catch (\Exception $e) {
            $this->Flash->warning(__('Invoice saved, but email could not be sent: ' . $e->getMessage()));
        }
    }
}
