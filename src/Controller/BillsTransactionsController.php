<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * BillsTransactions Controller
 *
 */
class BillsTransactionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BillsTransactions->find();
        $billsTransactions = $this->paginate($query);

        $this->set(compact('billsTransactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Bills Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billsTransaction = $this->BillsTransactions->get($id, contain: []);
        $this->set(compact('billsTransaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billsTransaction = $this->BillsTransactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $billsTransaction = $this->BillsTransactions->patchEntity($billsTransaction, $this->request->getData());
            if ($this->BillsTransactions->save($billsTransaction)) {
                $this->Flash->success(__('The bills transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bills transaction could not be saved. Please, try again.'));
        }
        $this->set(compact('billsTransaction'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bills Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $billsTransaction = $this->BillsTransactions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $billsTransaction = $this->BillsTransactions->patchEntity($billsTransaction, $this->request->getData());
            if ($this->BillsTransactions->save($billsTransaction)) {
                $this->Flash->success(__('The bills transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bills transaction could not be saved. Please, try again.'));
        }
        $this->set(compact('billsTransaction'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bills Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billsTransaction = $this->BillsTransactions->get($id);
        if ($this->BillsTransactions->delete($billsTransaction)) {
            $this->Flash->success(__('The bills transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The bills transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
