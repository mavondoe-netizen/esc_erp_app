<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;
use Dompdf\Dompdf;

/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 */
class InvoicesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Invoices')->find()
            ->contain(['Customers']);
        $invoices = $this->paginate($query);

        $this->set(compact('invoices'));
    }

    /**
     * View method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoice = $this->fetchTable('Invoices')->get($id, [
            'contain' => ['Customers' => ['Contacts'], 'Accounts', 'Transactions', 'InvoiceItems' => ['Products']]
        ]);
        
        $companyId = $invoice->company_id;
        $company = $this->fetchTable('Companies')->get($companyId);

        $this->set(compact('invoice', 'company'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
      public function add()
{
    $invoice = $this->fetchTable('Invoices')->newEmptyEntity();

    if ($this->request->is('post')) {
        $invoice = $this->fetchTable('Invoices')->patchEntity($invoice, $this->request->getData(), [
            'associated' => ['InvoiceItems', 'Customers', 'Transactions']
        ]);
        
        if ($this->fetchTable('Invoices')->save($invoice)) {
            // Only post ledger transactions when invoice is finalised (paid or sent)
            $postableStatuses = ['paid', 'sent'];
            if (in_array(strtolower((string)($invoice->status ?? '')), $postableStatuses)) {
                $transactionsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Transactions');
                $companyId = \Cake\Core\Configure::read('Tenant.company_id');
                $zarRate = 18.5;

                foreach ($invoice->invoice_items as $item) {
                    $txGroup = \Cake\Utility\Text::uuid();
                    if ($invoice->currency === 'ZAR') {
                        $zwgAmount = round((float)$item->line_total / (float)$zarRate, 2);
                        $transaction1 = $transactionsTable->newEntity([
                            'date'        => $invoice->date,
                            'description' => $invoice->description,
                            'currency'    => $invoice->currency,
                            'zwg'         => $zwgAmount,
                            'amount'      => $item->line_total,
                            'customer_id' => $invoice->customer_id,
                            'account_id'  => 1,
                            'company_id'  => $companyId,
                            'type'        => '2',
                            'transaction_group' => $txGroup,
                        ]);
                        $transaction2 = $transactionsTable->newEntity([
                            'date'        => $invoice->date,
                            'description' => $invoice->description,
                            'amount'      => $item->line_total,
                            'zwg'         => $zwgAmount,
                            'currency'    => $invoice->currency,
                            'account_id'  => $item->account_id,
                            'company_id'  => $companyId,
                            'type'        => '1',
                            'transaction_group' => $txGroup,
                        ]);
                    } elseif ($invoice->currency === 'USD') {
                        $transaction1 = $transactionsTable->newEntity([
                            'date'        => $invoice->date,
                            'description' => $invoice->description,
                            'amount'      => $item->line_total,
                            'zwg'         => $item->line_total,
                            'currency'    => $invoice->currency,
                            'customer_id' => $invoice->customer_id,
                            'account_id'  => 1,
                            'company_id'  => $companyId,
                            'type'        => '2',
                            'transaction_group' => $txGroup,
                        ]);
                        $transaction2 = $transactionsTable->newEntity([
                            'date'        => $invoice->date,
                            'description' => $invoice->description,
                            'zwg'         => $item->line_total,
                            'amount'      => $item->line_total,
                            'currency'    => $invoice->currency,
                            'account_id'  => $item->account_id,
                            'company_id'  => $companyId,
                            'type'        => '1',
                            'transaction_group' => $txGroup,
                        ]);
                    } else {
                        continue; // unknown currency — skip
                    }
                    $transactionsTable->save($transaction1);
                    $transactionsTable->save($transaction2);
                }
            }

            $this->Flash->success(__('Invoice saved successfully.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__('The invoice could not be saved. Please try again.'));
    }
    $customers    = $this->fetchTable('Invoices')->Customers->find('list');
    $accounts     = $this->fetchTable('Invoices')->InvoiceItems->Accounts->find('list');
    $transactions = $this->fetchTable('Invoices')->Transactions->find('list');

    $productsData    = $this->fetchTable('Products')->find('all')->all();
    $productsOptions = [];
    $productsJson    = [];
    foreach ($productsData as $prod) {
        $productsOptions[$prod->id] = $prod->name;
        $productsJson[$prod->id] = [
            'unit_price' => $prod->unit_price,
            'vat_rate'   => $prod->vat_rate,
            'account_id' => $prod->account_id,
        ];
    }

    $this->set(compact('invoice', 'accounts', 'customers', 'transactions', 'productsOptions', 'productsJson'));
}


    /**
     * Edit method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoice = $this->fetchTable('Invoices')->get($id, [
            'contain' => ['InvoiceItems', 'Accounts', 'Transactions'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoice = $this->fetchTable('Invoices')->patchEntity($invoice, $this->request->getData());
            if ($this->fetchTable('Invoices')->save($invoice)) {
                $transactionsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Transactions');
                $companyId = \Cake\Core\Configure::read('Tenant.company_id');
                $postableStatuses = ['paid', 'sent'];

                if (in_array(strtolower((string)($invoice->status ?? '')), $postableStatuses)) {
                    // Check if transactions have ALREADY been posted for this invoice.
                    // A paid invoice posts exactly once — it never re-posts on subsequent saves.
                    $conn = $this->fetchTable('Invoices')->getConnection();
                    $alreadyPosted = (int)($conn->execute(
                        'SELECT COUNT(*) AS cnt FROM invoices_transactions WHERE invoice_id = ?',
                        [$invoice->id]
                    )->fetch('assoc')['cnt'] ?? 0);

                    if ($alreadyPosted === 0) {
                        // First time reaching paid/sent — post the ledger entries
                        $zarRate = 18.5;
                        foreach ($invoice->invoice_items as $item) {
                            $txGroup = \Cake\Utility\Text::uuid();
                            if ($invoice->currency === 'ZAR') {
                                $zwgAmount = round((float)$item->line_total / (float)$zarRate, 2);
                                $transaction1 = $transactionsTable->newEntity([
                                    'date'        => $invoice->date,
                                    'description' => $invoice->description,
                                    'zwg'         => $zwgAmount,
                                    'amount'      => $item->line_total,
                                    'currency'    => $invoice->currency,
                                    'customer_id' => $invoice->customer_id,
                                    'account_id'  => 1,
                                    'company_id'  => $companyId,
                                    'type'        => '2',
                                    'transaction_group' => $txGroup,
                                ]);
                                $transaction2 = $transactionsTable->newEntity([
                                    'date'        => $invoice->date,
                                    'description' => $invoice->description,
                                    'zwg'         => $zwgAmount,
                                    'amount'      => $item->line_total,
                                    'currency'    => $invoice->currency,
                                    'account_id'  => $item->account_id,
                                    'company_id'  => $companyId,
                                    'type'        => '1',
                                    'transaction_group' => $txGroup,
                                ]);
                            } elseif ($invoice->currency === 'USD') {
                                $transaction1 = $transactionsTable->newEntity([
                                    'date'        => $invoice->date,
                                    'description' => $invoice->description,
                                    'amount'      => $item->line_total,
                                    'zwg'         => $item->line_total,
                                    'currency'    => $invoice->currency,
                                    'customer_id' => $invoice->customer_id,
                                    'account_id'  => 1,
                                    'company_id'  => $companyId,
                                    'type'        => '2',
                                    'transaction_group' => $txGroup,
                                ]);
                                $transaction2 = $transactionsTable->newEntity([
                                    'date'        => $invoice->date,
                                    'description' => $invoice->description,
                                    'zwg'         => $item->line_total,
                                    'amount'      => $item->line_total,
                                    'currency'    => $invoice->currency,
                                    'account_id'  => $item->account_id,
                                    'company_id'  => $companyId,
                                    'type'        => '1',
                                    'transaction_group' => $txGroup,
                                ]);
                            } else {
                                continue; // Unknown currency — skip
                            }
                            $transactionsTable->save($transaction1);
                            $transactionsTable->save($transaction2);
                        }
                    }
                    // If $alreadyPosted > 0: invoice was already posted — do nothing to the ledger.
                }

                $this->Flash->success(__('Invoice saved successfully.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The invoice could not be saved. Please try again.'));

        }
        $customers    = $this->fetchTable('Invoices')->Customers->find('list');
        $accounts     = $this->fetchTable('Invoices')->InvoiceItems->Accounts->find('list');
        $transactions = $this->fetchTable('Invoices')->Transactions->find('list');

        $productsData    = $this->fetchTable('Products')->find('all')->all();
        $productsOptions = [];
        $productsJson    = [];
        foreach ($productsData as $prod) {
            $productsOptions[$prod->id] = $prod->name;
            $productsJson[$prod->id] = [
                'unit_price' => $prod->unit_price,
                'vat_rate'   => $prod->vat_rate,
                'account_id' => $prod->account_id,
            ];
        }

        $this->set(compact('invoice', 'accounts', 'customers', 'transactions', 'productsOptions', 'productsJson'));
    } 

    /**
     * Delete method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoice = $this->fetchTable('Invoices')->get($id);
        if ($this->fetchTable('Invoices')->delete($invoice)) {
            $this->Flash->success(__('The invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
