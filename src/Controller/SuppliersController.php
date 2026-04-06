<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Suppliers Controller
 *
 * @property \App\Model\Table\SuppliersTable $Suppliers
 */
class SuppliersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Suppliers')->find()
            ->contain(['Contacts']);
        $suppliers = $this->paginate($query);

        $this->set(compact('suppliers'));
    }

    /**
     * View method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $supplier = $this->fetchTable('Suppliers')->get($id, contain: ['Contacts', 'Bills', 'Transactions']);
        $this->set(compact('supplier'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $supplier = $this->fetchTable('Suppliers')->newEmptyEntity();
        if ($this->request->is('post')) {
            $supplier = $this->fetchTable('Suppliers')->patchEntity($supplier, $this->request->getData());
            if ($this->fetchTable('Suppliers')->save($supplier)) {
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Suppliers')->Contacts->find('list', limit: 200)->all();
        $this->set(compact('supplier', 'contacts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $supplier = $this->fetchTable('Suppliers')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $supplier = $this->fetchTable('Suppliers')->patchEntity($supplier, $this->request->getData());
            if ($this->fetchTable('Suppliers')->save($supplier)) {
                $this->Flash->success(__('The supplier has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Suppliers')->Contacts->find('list', limit: 200)->all();
        $this->set(compact('supplier', 'contacts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $supplier = $this->fetchTable('Suppliers')->get($id);
        if ($this->fetchTable('Suppliers')->delete($supplier)) {
            $this->Flash->success(__('The supplier has been deleted.'));
        } else {
            $this->Flash->error(__('The supplier could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
