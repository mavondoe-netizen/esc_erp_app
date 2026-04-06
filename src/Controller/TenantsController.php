<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tenants Controller
 *
 * @property \App\Model\Table\TenantsTable $Tenants
 */
class TenantsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Tenants')->find()
            ->contain(['Contacts']);
        $tenants = $this->paginate($query);

        $this->set(compact('tenants'));
    }

    /**
     * View method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tenant = $this->fetchTable('Tenants')->get($id, contain: ['Contacts', 'Enrolments', 'Transactions']);
        $this->set(compact('tenant'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tenant = $this->fetchTable('Tenants')->newEmptyEntity();
        if ($this->request->is('post')) {
            $tenant = $this->fetchTable('Tenants')->patchEntity($tenant, $this->request->getData());
            if ($this->fetchTable('Tenants')->save($tenant)) {
                $this->Flash->success(__('The tenant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Tenants')->Contacts->find('list', limit: 200)->all();
        $this->set(compact('tenant', 'contacts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tenant = $this->fetchTable('Tenants')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tenant = $this->fetchTable('Tenants')->patchEntity($tenant, $this->request->getData());
            if ($this->fetchTable('Tenants')->save($tenant)) {
                $this->Flash->success(__('The tenant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }
        $contacts = $this->fetchTable('Tenants')->Contacts->find('list', limit: 200)->all();
        $this->set(compact('tenant', 'contacts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tenant = $this->fetchTable('Tenants')->get($id);
        if ($this->fetchTable('Tenants')->delete($tenant)) {
            $this->Flash->success(__('The tenant has been deleted.'));
        } else {
            $this->Flash->error(__('The tenant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
