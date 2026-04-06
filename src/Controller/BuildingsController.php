<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Buildings Controller
 *
 * @property \App\Model\Table\BuildingsTable $Buildings
 */
class BuildingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Buildings')->find()
            ->contain(['Investors']);
        $buildings = $this->paginate($query);

        $this->set(compact('buildings'));
    }

    /**
     * View method
     *
     * @param string|null $id Building id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $building = $this->fetchTable('Buildings')->get($id, contain: ['Investors', 'Bills', 'Transactions', 'Units']);
        $this->set(compact('building'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $building = $this->fetchTable('Buildings')->newEmptyEntity();
        if ($this->request->is('post')) {
            $building = $this->fetchTable('Buildings')->patchEntity($building, $this->request->getData());
            if ($this->fetchTable('Buildings')->save($building)) {
                $this->Flash->success(__('The building has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The building could not be saved. Please, try again.'));
        }
        $investors = $this->fetchTable('Buildings')->Investors->find('list', limit: 200)->all();
        $this->set(compact('building', 'investors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Building id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $building = $this->fetchTable('Buildings')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $building = $this->fetchTable('Buildings')->patchEntity($building, $this->request->getData());
            if ($this->fetchTable('Buildings')->save($building)) {
                $this->Flash->success(__('The building has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The building could not be saved. Please, try again.'));
        }
        $investors = $this->fetchTable('Buildings')->Investors->find('list', limit: 200)->all();
        $this->set(compact('building', 'investors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Building id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $building = $this->fetchTable('Buildings')->get($id);
        if ($this->fetchTable('Buildings')->delete($building)) {
            $this->Flash->success(__('The building has been deleted.'));
        } else {
            $this->Flash->error(__('The building could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
