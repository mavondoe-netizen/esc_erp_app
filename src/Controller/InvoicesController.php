<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Invoices Controller
 *
 * Sales invoices — CRUD, line-item management, and ledger posting.
 * Implements a "post-once" guard: ledger entries are only created on first
 * save (status change to "Sent"/"Posted") and never duplicated on edit.
 */
class InvoicesController extends AppController
{
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
        $companyId = $this->request->getAttribute('company_id');

        $invoice = $this->fetchTable('Invoices')
            ->get($id, contain: ['Customers', 'InvoiceItems' => ['Accounts'], 'Transactions' => ['Accounts']]);

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
                // Post ledger entries if status is not Draft
                if (!in_array($invoice->status, ['Draft'])) {
                    $this->_postInvoiceToLedger($invoice, $companyId);
                }
                $this->Flash->success(__('Invoice saved.'));
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
                $this->_reverseInvoiceLedger($invoice->id, $companyId);

                // Re-post to ledger if status is not Draft
                if ($newStatus !== 'Draft') {
                    $this->_postInvoiceToLedger($invoice, $companyId);
                }

                $this->Flash->success(__('Invoice updated.'));
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

        // To pre-select the correct contact in the dropdown, we need the contact_id for this customer
        $currentContactId = null;
        if ($invoice->customer_id) {
            $customer = $this->fetchTable('Customers')->get($invoice->customer_id);
            $currentContactId = $customer->contact_id;
        }

        $this->set(compact('invoice', 'customers', 'accounts', 'productsOptions', 'productsJson', 'currentContactId'));
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
        $this->_reverseInvoiceLedger($invoice->id, $companyId);

        if ($Invoices->delete($invoice)) {
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
                $this->_postPaymentToLedger($invoice, (int)$paymentAccountId, $companyId);
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
    // PRIVATE — LEDGER POSTING HELPERS
    // -----------------------------------------------------------------------

    private function _postInvoiceToLedger($invoice, int $companyId): void
    {
        $Invoices = $this->fetchTable('Invoices');

        if (!isset($invoice->invoice_items) || empty($invoice->invoice_items)) {
            $invoice = $Invoices->get($invoice->id, contain: ['InvoiceItems']);
        }

        $Transactions = $this->fetchTable('Transactions');
        $Accounts     = $this->fetchTable('Accounts');

        $arAccount = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.category LIKE' => '%Receivable%'])
            ->first();

        $arAccountId = $arAccount ? $arAccount->id : null;
        if (!$arAccountId) return; 

        $date      = $invoice->date ? $invoice->date->format('Y-m-d') : date('Y-m-d');
        $ref       = $invoice->reference ?? "INV-{$invoice->id}";
        $currency  = $invoice->currency ?? 'USD';
        $groupId   = Text::uuid();

        $Transactions->getConnection()->transactional(function () use (
            $Transactions, $invoice, $arAccountId, $date, $ref, $currency, $groupId, $companyId
        ) {
            $total = (float)($invoice->total ?? 0);

            $dr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Invoice $ref",
                'currency'          => $currency,
                'amount'            => $total,
                'zwg'               => $total,
                'type'              => 'Debit',
                'account_id'        => $arAccountId,
                'customer_id'       => $invoice->customer_id,
                'invoice_id'        => $invoice->id,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($dr, ['check_balance' => false]);

            if (!empty($invoice->invoice_items)) {
                foreach ($invoice->invoice_items as $item) {
                    $itemTotal = (float)($item->total ?? ($item->quantity ?? 1) * ($item->unit_price ?? 0));
                    if (!$item->account_id || $itemTotal == 0) continue;

                    $cr = $Transactions->newEntity([
                        'company_id'        => $companyId,
                        'date'              => $date,
                        'description'       => "Invoice $ref — " . ($item->description ?? ''),
                        'currency'          => $currency,
                        'amount'            => $itemTotal,
                        'zwg'               => $itemTotal,
                        'type'              => 'Credit',
                        'account_id'        => $item->account_id,
                        'customer_id'       => $invoice->customer_id,
                        'invoice_id'        => $invoice->id,
                        'transaction_group' => $groupId,
                    ], ['validate' => false]);
                    $Transactions->save($cr, ['check_balance' => false]);
                }
            } else {
                $cr = $Transactions->newEntity([
                    'company_id'        => $companyId,
                    'date'              => $date,
                    'description'       => "Invoice $ref",
                    'currency'          => $currency,
                    'amount'            => $total,
                    'zwg'               => $total,
                    'type'              => 'Credit',
                    'account_id'        => $arAccountId, // fallback
                    'customer_id'       => $invoice->customer_id,
                    'invoice_id'        => $invoice->id,
                    'transaction_group' => $groupId,
                ], ['validate' => false]);
                $Transactions->save($cr, ['check_balance' => false]);
            }
        });
    }

    private function _postPaymentToLedger($invoice, int $paymentAccountId, int $companyId): void
    {
        $Transactions = $this->fetchTable('Transactions');
        $Accounts     = $this->fetchTable('Accounts');

        $arAccount = $Accounts->find()
            ->where(['Accounts.company_id' => $companyId, 'Accounts.category LIKE' => '%Receivable%'])
            ->first();

        if (!$arAccount) return;

        $date     = date('Y-m-d');
        $ref      = $invoice->reference ?? "INV-{$invoice->id}";
        $total    = (float)($invoice->total ?? 0);
        $currency = $invoice->currency ?? 'USD';
        $groupId  = Text::uuid();

        $Transactions->getConnection()->transactional(function () use (
            $Transactions, $arAccount, $invoice, $paymentAccountId,
            $date, $ref, $total, $currency, $groupId, $companyId
        ) {
            $dr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Payment received — $ref",
                'currency'          => $currency,
                'amount'            => $total,
                'zwg'               => $total,
                'type'              => 'Debit',
                'account_id'        => $paymentAccountId,
                'customer_id'       => $invoice->customer_id,
                'invoice_id'        => $invoice->id,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($dr, ['check_balance' => false]);

            $cr = $Transactions->newEntity([
                'company_id'        => $companyId,
                'date'              => $date,
                'description'       => "Payment received — $ref",
                'currency'          => $currency,
                'amount'            => $total,
                'zwg'               => $total,
                'type'              => 'Credit',
                'account_id'        => $arAccount->id,
                'customer_id'       => $invoice->customer_id,
                'invoice_id'        => $invoice->id,
                'transaction_group' => $groupId,
            ], ['validate' => false]);
            $Transactions->save($cr, ['check_balance' => false]);
        });
    }

    private function _reverseInvoiceLedger(int $invoiceId, int $companyId): void
    {
        $Transactions = $this->fetchTable('Transactions');

        $groups = $Transactions->find()
            ->where(['Transactions.invoice_id' => $invoiceId, 'Transactions.company_id' => $companyId])
            ->select(['transaction_group'])
            ->distinct(['transaction_group'])
            ->all()
            ->extract('transaction_group')
            ->filter()
            ->toArray();

        if (!empty($groups)) {
            $Transactions->deleteAll([
                'Transactions.transaction_group IN' => $groups,
                'Transactions.company_id'           => $companyId,
            ]);
        }
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
}
