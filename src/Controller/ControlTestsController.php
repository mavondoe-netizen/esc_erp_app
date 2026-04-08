<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ControlTests Controller
 *
 * @property \App\Model\Table\ControlTestsTable $ControlTests
 */
class ControlTestsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ControlTests->find()
            ->contain(['Companies', 'Controls']);
        $controlTests = $this->paginate($query);

        $this->set(compact('controlTests'));
    }

    /**
     * View method
     *
     * @param string|null $id Control Test id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $controlTest = $this->ControlTests->get($id, contain: ['Companies', 'Controls']);
        $this->set(compact('controlTest'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $controlTest = $this->ControlTests->newEmptyEntity();
        if ($this->request->is('post')) {
            $controlTest = $this->ControlTests->patchEntity($controlTest, $this->request->getData());
            if ($this->ControlTests->save($controlTest)) {
                $this->Flash->success(__('The control test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The control test could not be saved. Please, try again.'));
        }
        $companies = $this->ControlTests->Companies->find('list', limit: 200)->all();
        $controls = $this->ControlTests->Controls->find('list', limit: 200)->all();
        $this->set(compact('controlTest', 'companies', 'controls'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Control Test id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $controlTest = $this->ControlTests->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $controlTest = $this->ControlTests->patchEntity($controlTest, $this->request->getData());
            if ($this->ControlTests->save($controlTest)) {
                $this->Flash->success(__('The control test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The control test could not be saved. Please, try again.'));
        }
        $companies = $this->ControlTests->Companies->find('list', limit: 200)->all();
        $controls = $this->ControlTests->Controls->find('list', limit: 200)->all();
        $this->set(compact('controlTest', 'companies', 'controls'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Control Test id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $controlTest = $this->ControlTests->get($id);
        if ($this->ControlTests->delete($controlTest)) {
            $this->Flash->success(__('The control test has been deleted.'));
        } else {
            $this->Flash->error(__('The control test could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
