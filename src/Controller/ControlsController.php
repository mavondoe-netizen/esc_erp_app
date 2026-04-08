<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Controls Controller
 *
 * @property \App\Model\Table\ControlsTable $Controls
 */
class ControlsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Controls->find()
            ->contain(['Companies', 'Risks']);
        $controls = $this->paginate($query);

        $this->set(compact('controls'));
    }

    /**
     * View method
     *
     * @param string|null $id Control id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $control = $this->Controls->get($id, contain: ['Companies', 'Risks', 'ControlTests']);
        $this->set(compact('control'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $control = $this->Controls->newEmptyEntity();
        if ($this->request->is('post')) {
            $control = $this->Controls->patchEntity($control, $this->request->getData());
            if ($this->Controls->save($control)) {
                $this->Flash->success(__('The control has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The control could not be saved. Please, try again.'));
        }
        $companies = $this->Controls->Companies->find('list', limit: 200)->all();
        $risks = $this->Controls->Risks->find('list', limit: 200)->all();
        $this->set(compact('control', 'companies', 'risks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Control id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $control = $this->Controls->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $control = $this->Controls->patchEntity($control, $this->request->getData());
            if ($this->Controls->save($control)) {
                $this->Flash->success(__('The control has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The control could not be saved. Please, try again.'));
        }
        $companies = $this->Controls->Companies->find('list', limit: 200)->all();
        $risks = $this->Controls->Risks->find('list', limit: 200)->all();
        $this->set(compact('control', 'companies', 'risks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Control id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $control = $this->Controls->get($id);
        if ($this->Controls->delete($control)) {
            $this->Flash->success(__('The control has been deleted.'));
        } else {
            $this->Flash->error(__('The control could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
