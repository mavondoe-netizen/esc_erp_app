<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * BillItems Controller
 *
 * @property \App\Model\Table\BillItemsTable $BillItems
 */
class BillItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('BillItems')->find()
            ->contain(['Bills', 'Accounts']);
        $billItems = $this->paginate($query);

        $this->set(compact('billItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Bill Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billItem = $this->fetchTable('BillItems')->get($id, contain: ['Bills', 'Accounts']);
        $this->set(compact('billItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billItem = $this->fetchTable('BillItems')->newEmptyEntity();
        if ($this->request->is('post')) {
            $billItem = $this->fetchTable('BillItems')->patchEntity($billItem, $this->request->getData());
            if ($this->fetchTable('BillItems')->save($billItem)) {
                $this->Flash->success(__('The bill item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bill item could not be saved. Please, try again.'));
        }
        $bills = $this->fetchTable('BillItems')->Bills->find('list', limit: 200)->all();
        $accounts = $this->fetchTable('BillItems')->Accounts->find('list', limit: 200)->all();
        $this->set(compact('billItem', 'bills', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bill Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $billItem = $this->fetchTable('BillItems')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $billItem = $this->fetchTable('BillItems')->patchEntity($billItem, $this->request->getData());
            if ($this->fetchTable('BillItems')->save($billItem)) {
                $this->Flash->success(__('The bill item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bill item could not be saved. Please, try again.'));
        }
        $bills = $this->fetchTable('BillItems')->Bills->find('list', limit: 200)->all();
        $accounts = $this->fetchTable('BillItems')->Accounts->find('list', limit: 200)->all();
        $this->set(compact('billItem', 'bills', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bill Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billItem = $this->fetchTable('BillItems')->get($id);
        if ($this->fetchTable('BillItems')->delete($billItem)) {
            $this->Flash->success(__('The bill item has been deleted.'));
        } else {
            $this->Flash->error(__('The bill item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
