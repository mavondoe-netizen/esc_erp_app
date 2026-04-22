<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Levies Controller
 *
 * @property \App\Model\Table\LeviesTable $Levies
 */
class LeviesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Levies->find()
            ->contain(['Companies', 'Enrolments', 'Tenants', 'Units', 'Buildings', 'Accounts']);
        $levies = $this->paginate($query);

        $this->set(compact('levies'));
    }

    /**
     * View method
     *
     * @param string|null $id Levy id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $levy = $this->Levies->get($id, contain: ['Companies', 'Enrolments', 'Tenants', 'Units', 'Buildings', 'Accounts']);
        $this->set(compact('levy'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $levy = $this->Levies->newEmptyEntity();
        if ($this->request->is('post')) {
            $levy = $this->Levies->patchEntity($levy, $this->request->getData());
            if ($this->Levies->save($levy)) {
                $this->Flash->success(__('The levy has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The levy could not be saved. Please, try again.'));
        }
        $companies = $this->Levies->Companies->find('list', limit: 200)->all();
        $enrolments = $this->Levies->Enrolments->find('list', limit: 200)->all();
        $tenants = $this->Levies->Tenants->find('list', limit: 200)->all();
        $units = $this->Levies->Units->find('list', limit: 200)->all();
        $buildings = $this->Levies->Buildings->find('list', limit: 200)->all();
        $accounts = $this->Levies->Accounts->find('list', limit: 200)->all();
        $this->set(compact('levy', 'companies', 'enrolments', 'tenants', 'units', 'buildings', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Levy id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $levy = $this->Levies->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $levy = $this->Levies->patchEntity($levy, $this->request->getData());
            if ($this->Levies->save($levy)) {
                $this->Flash->success(__('The levy has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The levy could not be saved. Please, try again.'));
        }
        $companies = $this->Levies->Companies->find('list', limit: 200)->all();
        $enrolments = $this->Levies->Enrolments->find('list', limit: 200)->all();
        $tenants = $this->Levies->Tenants->find('list', limit: 200)->all();
        $units = $this->Levies->Units->find('list', limit: 200)->all();
        $buildings = $this->Levies->Buildings->find('list', limit: 200)->all();
        $accounts = $this->Levies->Accounts->find('list', limit: 200)->all();
        $this->set(compact('levy', 'companies', 'enrolments', 'tenants', 'units', 'buildings', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Levy id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $levy = $this->Levies->get($id);
        if ($this->Levies->delete($levy)) {
            $this->Flash->success(__('The levy has been deleted.'));
        } else {
            $this->Flash->error(__('The levy could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
