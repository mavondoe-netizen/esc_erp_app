<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Receipts Controller
 *
 * @property \App\Model\Table\ReceiptsTable $Receipts
 */
class ReceiptsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Receipts')->find()
            ->contain([ 'Accounts']);
        $receipts = $this->paginate($query);

        $this->set(compact('receipts'));
    }

    /**
     * View method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $receipt = $this->fetchTable('Receipts')->get($id, contain: [ 'Accounts', 'Transactions']);
        $this->set(compact('receipt'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $receipt = $this->fetchTable('Receipts')->newEmptyEntity();
        if ($this->request->is('post')) {
            $receipt = $this->fetchTable('Receipts')->patchEntity($receipt, $this->request->getData());
            if ($this->fetchTable('Receipts')->save($receipt)) {
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
        }
       
        $accounts = $this->fetchTable('Receipts')->Accounts->find('list', limit: 200)->all();
        $transactions = $this->fetchTable('Receipts')->Transactions->find('list', limit: 200)->all();
        $this->set(compact('receipt',  'accounts', 'transactions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $receipt = $this->fetchTable('Receipts')->get($id, contain: ['Transactions']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $receipt = $this->fetchTable('Receipts')->patchEntity($receipt, $this->request->getData());
            if ($this->fetchTable('Receipts')->save($receipt)) {
                $this->Flash->success(__('The receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The receipt could not be saved. Please, try again.'));
        }
        
        $accounts = $this->fetchTable('Receipts')->Accounts->find('list', limit: 200)->all();
        $transactions = $this->fetchTable('Receipts')->Transactions->find('list', limit: 200)->all();
        $this->set(compact('receipt',  'accounts', 'transactions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Receipt id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $receipt = $this->fetchTable('Receipts')->get($id);
        if ($this->fetchTable('Receipts')->delete($receipt)) {
            $this->Flash->success(__('The receipt has been deleted.'));
        } else {
            $this->Flash->error(__('The receipt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
