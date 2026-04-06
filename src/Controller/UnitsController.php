<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Units Controller
 *
 * @property \App\Model\Table\UnitsTable $Units
 */
class UnitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Units')->find()
            ->contain(['Buildings']);
        $units = $this->paginate($query);

        $this->set(compact('units'));
    }

    /**
     * View method
     *
     * @param string|null $id Unit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $unit = $this->fetchTable('Units')->get($id, contain: ['Buildings', 'Enrolments']);
        $this->set(compact('unit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $unit = $this->fetchTable('Units')->newEmptyEntity();
        if ($this->request->is('post')) {
            $unit = $this->fetchTable('Units')->patchEntity($unit, $this->request->getData());
            if ($this->fetchTable('Units')->save($unit)) {
                $this->Flash->success(__('The unit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unit could not be saved. Please, try again.'));
        }
        $buildings = $this->fetchTable('Units')->Buildings->find('list', limit: 200)->all();
        $this->set(compact('unit', 'buildings'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Unit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $unit = $this->fetchTable('Units')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $unit = $this->fetchTable('Units')->patchEntity($unit, $this->request->getData());
            if ($this->fetchTable('Units')->save($unit)) {
                $this->Flash->success(__('The unit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unit could not be saved. Please, try again.'));
        }
        $buildings = $this->fetchTable('Units')->Buildings->find('list', limit: 200)->all();
        $this->set(compact('unit', 'buildings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Unit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $unit = $this->fetchTable('Units')->get($id);
        if ($this->fetchTable('Units')->delete($unit)) {
            $this->Flash->success(__('The unit has been deleted.'));
        } else {
            $this->Flash->error(__('The unit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
