<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Bills Controller
 *
 * @property \App\Model\Table\BillsTable $Bills
 */
class BillsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Bills')->find()
            ->contain(['Suppliers']);
        $bills = $this->paginate($query);

        $this->set(compact('bills'));
    }

    /**
     * View method
     *
     * @param string|null $id Bill id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bill = $this->fetchTable('Bills')->get($id, contain: ['Suppliers', 'Transactions']);
        
        $companyId = $this->request->getAttribute('identity')->company_id;
        $company = $this->fetchTable('Companies')->get($companyId);
        
        $this->set(compact('bill', 'company'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bill = $this->fetchTable('Bills')->newEmptyEntity();
        if ($this->request->is('post')) {
            $bill = $this->fetchTable('Bills')->patchEntity($bill, $this->request->getData());
            if ($this->fetchTable('Bills')->save($bill)) {
                $this->Flash->success(__('The bill has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bill could not be saved. Please, try again.'));
        }
        $suppliers = $this->fetchTable('Bills')->Suppliers->find('list', limit: 200)->all();
        $transactions = $this->fetchTable('Bills')->Transactions->find('list', limit: 200)->all();
        $accounts = $this->fetchTable('Bills')->Accounts->find('list', limit: 200)->all();
        $this->set(compact('bill', 'suppliers', 'transactions', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bill id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bill = $this->fetchTable('Bills')->get($id, contain: ['Transactions']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bill = $this->fetchTable('Bills')->patchEntity($bill, $this->request->getData());
            if ($this->fetchTable('Bills')->save($bill)) {
                $this->Flash->success(__('The bill has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bill could not be saved. Please, try again.'));
        }
        $suppliers = $this->fetchTable('Bills')->Suppliers->find('list', limit: 200)->all();
        $transactions = $this->fetchTable('Bills')->Transactions->find('list', limit: 200)->all();
        $accounts = $this->fetchTable('Bills')->Accounts->find('list', limit: 200)->all();
        $this->set(compact('bill', 'suppliers', 'transactions', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bill id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bill = $this->fetchTable('Bills')->get($id);
        if ($this->fetchTable('Bills')->delete($bill)) {
            $this->Flash->success(__('The bill has been deleted.'));
        } else {
            $this->Flash->error(__('The bill could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
