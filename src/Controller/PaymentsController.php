<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Payments->find()
            ->contain(['Companies', 'Customers', 'Accounts']);
        $payments = $this->paginate($query);

        $this->set(compact('payments'));
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, contain: ['Companies', 'Customers', 'Accounts']);
        $this->set(compact('payment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payment = $this->Payments->newEmptyEntity();
        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            $payment->company_id = \Cake\Core\Configure::read('Tenant.company_id');

            if ($this->Payments->save($payment)) {
                
                $transactionsTable = $this->fetchTable('Transactions');
                $txGroup = \Cake\Utility\Text::uuid();
                
                // 1. Debit the Bank/Cash Account (Increase Asset)
                $txDebit = $transactionsTable->newEntity([
                    'date'        => $payment->date,
                    'description' => trim('Payment Recv ' . $payment->reference . ' ' . $payment->description),
                    'amount'      => $payment->amount,
                    'zwg'         => $payment->amount,
                    'currency'    => $payment->currency,
                    'customer_id' => $payment->customer_id,
                    'account_id'  => $payment->account_id,
                    'company_id'  => $payment->company_id,
                    'type'        => '2', // Debit
                    'transaction_group' => $txGroup
                ]);
                
                // 2. Credit Accounts Receivable (Decrease Asset)
                $txCredit = $transactionsTable->newEntity([
                    'date'        => $payment->date,
                    'description' => trim('Payment App ' . $payment->reference . ' ' . $payment->description),
                    'amount'      => $payment->amount,
                    'zwg'         => $payment->amount,
                    'currency'    => $payment->currency,
                    'customer_id' => $payment->customer_id,
                    'account_id'  => 1, // Standard AR Account
                    'company_id'  => $payment->company_id,
                    'type'        => '1', // Credit
                    'transaction_group' => $txGroup
                ]);

                $transactionsTable->save($txDebit);
                $transactionsTable->save($txCredit);

                $this->Flash->success(__('The payment has been saved and posted to ledger.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        $customers = $this->Payments->Customers->find('list', limit: 200)->all();
        $accounts = $this->Payments->Accounts->find('list', ['conditions' => ['category IN' => ['Asset', 'Bank']]])->all();
        $this->set(compact('payment', 'customers', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be updated. Please try again.'));
        }
        $customers = $this->Payments->Customers->find('list', limit: 200)->all();
        $accounts = $this->Payments->Accounts->find('list', ['conditions' => ['category IN' => ['Asset', 'Bank']]])->all();
        $this->set(compact('payment', 'customers', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
