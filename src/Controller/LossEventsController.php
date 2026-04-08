<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LossEvents Controller
 *
 * @property \App\Model\Table\LossEventsTable $LossEvents
 */
class LossEventsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LossEvents->find()
            ->contain(['Companies', 'Incidents']);
        $lossEvents = $this->paginate($query);

        $this->set(compact('lossEvents'));
    }

    /**
     * View method
     *
     * @param string|null $id Loss Event id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lossEvent = $this->LossEvents->get($id, contain: ['Companies', 'Incidents']);
        $this->set(compact('lossEvent'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lossEvent = $this->LossEvents->newEmptyEntity();
        if ($this->request->is('post')) {
            $lossEvent = $this->LossEvents->patchEntity($lossEvent, $this->request->getData());
            if ($this->LossEvents->save($lossEvent)) {
                $this->Flash->success(__('The loss event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loss event could not be saved. Please, try again.'));
        }
        $companies = $this->LossEvents->Companies->find('list', limit: 200)->all();
        $incidents = $this->LossEvents->Incidents->find('list', limit: 200)->all();
        $this->set(compact('lossEvent', 'companies', 'incidents'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loss Event id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lossEvent = $this->LossEvents->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lossEvent = $this->LossEvents->patchEntity($lossEvent, $this->request->getData());
            if ($this->LossEvents->save($lossEvent)) {
                $this->Flash->success(__('The loss event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loss event could not be saved. Please, try again.'));
        }
        $companies = $this->LossEvents->Companies->find('list', limit: 200)->all();
        $incidents = $this->LossEvents->Incidents->find('list', limit: 200)->all();
        $this->set(compact('lossEvent', 'companies', 'incidents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loss Event id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lossEvent = $this->LossEvents->get($id);
        if ($this->LossEvents->delete($lossEvent)) {
            $this->Flash->success(__('The loss event has been deleted.'));
        } else {
            $this->Flash->error(__('The loss event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
