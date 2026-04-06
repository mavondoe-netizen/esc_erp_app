<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Customers')->find()
            ->contain(['Contacts']);
        $customers = $this->paginate($query);

        $this->set(compact('customers'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customer = $this->fetchTable('Customers')->get($id, contain: ['Contacts', 'Inspections', 'Invoices']);
        $this->set(compact('customer'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->fetchTable('Customers')->newEmptyEntity();
        if ($this->request->is('post')) {
            $customer = $this->fetchTable('Customers')->patchEntity($customer, $this->request->getData());
            if ($this->fetchTable('Customers')->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Customers')->Contacts->find('list', limit: 200)->all();
        $this->set(compact('customer', 'contacts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->fetchTable('Customers')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->fetchTable('Customers')->patchEntity($customer, $this->request->getData());
            if ($this->fetchTable('Customers')->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Customers')->Contacts->find('list', limit: 200)->all();
        $this->set(compact('customer', 'contacts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->fetchTable('Customers')->get($id);
        if ($this->fetchTable('Customers')->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
