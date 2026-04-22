<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Repairs Controller
 *
 * @property \App\Model\Table\RepairsTable $Repairs
 */
class RepairsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Repairs->find()
            ->contain(['Companies', 'Units', 'Buildings', 'Tenants', 'Accounts']);
        $repairs = $this->paginate($query);

        $this->set(compact('repairs'));
    }

    /**
     * View method
     *
     * @param string|null $id Repair id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $repair = $this->Repairs->get($id, contain: ['Companies', 'Units', 'Buildings', 'Tenants', 'Accounts']);
        $this->set(compact('repair'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $repair = $this->Repairs->newEmptyEntity();
        if ($this->request->is('post')) {
            $repair = $this->Repairs->patchEntity($repair, $this->request->getData());
            if ($this->Repairs->save($repair)) {
                $this->Flash->success(__('The repair has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The repair could not be saved. Please, try again.'));
        }
        $companies = $this->Repairs->Companies->find('list', limit: 200)->all();
        $units = $this->Repairs->Units->find('list', limit: 200)->all();
        $buildings = $this->Repairs->Buildings->find('list', limit: 200)->all();
        $tenants = $this->Repairs->Tenants->find('list', limit: 200)->all();
        $accounts = $this->Repairs->Accounts->find('list', limit: 200)->all();
        $this->set(compact('repair', 'companies', 'units', 'buildings', 'tenants', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Repair id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $repair = $this->Repairs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $repair = $this->Repairs->patchEntity($repair, $this->request->getData());
            if ($this->Repairs->save($repair)) {
                $this->Flash->success(__('The repair has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The repair could not be saved. Please, try again.'));
        }
        $companies = $this->Repairs->Companies->find('list', limit: 200)->all();
        $units = $this->Repairs->Units->find('list', limit: 200)->all();
        $buildings = $this->Repairs->Buildings->find('list', limit: 200)->all();
        $tenants = $this->Repairs->Tenants->find('list', limit: 200)->all();
        $accounts = $this->Repairs->Accounts->find('list', limit: 200)->all();
        $this->set(compact('repair', 'companies', 'units', 'buildings', 'tenants', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Repair id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $repair = $this->Repairs->get($id);
        if ($this->Repairs->delete($repair)) {
            $this->Flash->success(__('The repair has been deleted.'));
        } else {
            $this->Flash->error(__('The repair could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
