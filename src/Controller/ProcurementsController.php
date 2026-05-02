<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Procurements Controller
 *
 * @property \App\Model\Table\ProcurementsTable $Procurements
 */
class ProcurementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Procurements->find()
            ->contain(['Requisitions', 'Users', 'Companies']);
        $procurements = $this->paginate($query);

        $this->set(compact('procurements'));
    }

    /**
     * View method
     *
     * @param string|null $id Procurement id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $procurement = $this->Procurements->get($id, contain: ['Requisitions', 'Users', 'Companies', 'Tenders']);
        $this->set(compact('procurement'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $procurement = $this->Procurements->newEmptyEntity();
        if ($this->request->is('post')) {
            $procurement = $this->Procurements->patchEntity($procurement, $this->request->getData());
            if ($this->Procurements->save($procurement)) {
                $this->Flash->success(__('The procurement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The procurement could not be saved. Please, try again.'));
        }
        $requisitions = $this->Procurements->Requisitions->find('list', limit: 200)->all();
        $users = $this->Procurements->Users->find('list', limit: 200)->all();
        $companies = $this->Procurements->Companies->find('list', limit: 200)->all();
        $this->set(compact('procurement', 'requisitions', 'users', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Procurement id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $procurement = $this->Procurements->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $procurement = $this->Procurements->patchEntity($procurement, $this->request->getData());
            if ($this->Procurements->save($procurement)) {
                $this->Flash->success(__('The procurement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The procurement could not be saved. Please, try again.'));
        }
        $requisitions = $this->Procurements->Requisitions->find('list', limit: 200)->all();
        $users = $this->Procurements->Users->find('list', limit: 200)->all();
        $companies = $this->Procurements->Companies->find('list', limit: 200)->all();
        $this->set(compact('procurement', 'requisitions', 'users', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Procurement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $procurement = $this->Procurements->get($id);
        if ($this->Procurements->delete($procurement)) {
            $this->Flash->success(__('The procurement has been deleted.'));
        } else {
            $this->Flash->error(__('The procurement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
