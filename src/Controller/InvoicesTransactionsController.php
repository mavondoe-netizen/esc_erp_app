<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * InvoicesTransactions Controller
 *
 */
class InvoicesTransactionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->InvoicesTransactions->find();
        $invoicesTransactions = $this->paginate($query);

        $this->set(compact('invoicesTransactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Invoices Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoicesTransaction = $this->InvoicesTransactions->get($id, contain: []);
        $this->set(compact('invoicesTransaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invoicesTransaction = $this->InvoicesTransactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $invoicesTransaction = $this->InvoicesTransactions->patchEntity($invoicesTransaction, $this->request->getData());
            if ($this->InvoicesTransactions->save($invoicesTransaction)) {
                $this->Flash->success(__('The invoices transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoices transaction could not be saved. Please, try again.'));
        }
        $this->set(compact('invoicesTransaction'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoices Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoicesTransaction = $this->InvoicesTransactions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoicesTransaction = $this->InvoicesTransactions->patchEntity($invoicesTransaction, $this->request->getData());
            if ($this->InvoicesTransactions->save($invoicesTransaction)) {
                $this->Flash->success(__('The invoices transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoices transaction could not be saved. Please, try again.'));
        }
        $this->set(compact('invoicesTransaction'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoices Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoicesTransaction = $this->InvoicesTransactions->get($id);
        if ($this->InvoicesTransactions->delete($invoicesTransaction)) {
            $this->Flash->success(__('The invoices transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The invoices transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
