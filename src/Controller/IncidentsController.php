<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Incidents Controller
 *
 * @property \App\Model\Table\IncidentsTable $Incidents
 */
class IncidentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Incidents->find()
            ->contain(['Companies']);
        $incidents = $this->paginate($query);

        $this->set(compact('incidents'));
    }

    /**
     * View method
     *
     * @param string|null $id Incident id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $incident = $this->Incidents->get($id, contain: ['Companies', 'LossEvents']);
        $this->set(compact('incident'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $incident = $this->Incidents->newEmptyEntity();
        if ($this->request->is('post')) {
            $incident = $this->Incidents->patchEntity($incident, $this->request->getData());
            if ($this->Incidents->save($incident)) {
                $this->Flash->success(__('The incident has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The incident could not be saved. Please, try again.'));
        }
        $companies = $this->Incidents->Companies->find('list', limit: 200)->all();
        $this->set(compact('incident', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Incident id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $incident = $this->Incidents->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $incident = $this->Incidents->patchEntity($incident, $this->request->getData());
            if ($this->Incidents->save($incident)) {
                $this->Flash->success(__('The incident has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The incident could not be saved. Please, try again.'));
        }
        $companies = $this->Incidents->Companies->find('list', limit: 200)->all();
        $this->set(compact('incident', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Incident id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $incident = $this->Incidents->get($id);
        if ($this->Incidents->delete($incident)) {
            $this->Flash->success(__('The incident has been deleted.'));
        } else {
            $this->Flash->error(__('The incident could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
