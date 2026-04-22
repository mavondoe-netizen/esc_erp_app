<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Claims Controller
 *
 */
class ClaimsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Claims->find();
        $claims = $this->paginate($query);

        $this->set(compact('claims'));
    }

    /**
     * View method
     *
     * @param string|null $id Claim id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $claim = $this->Claims->get($id, contain: []);
        $this->set(compact('claim'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $claim = $this->Claims->newEmptyEntity();
        if ($this->request->is('post')) {
            $claim = $this->Claims->patchEntity($claim, $this->request->getData());
            if ($this->Claims->save($claim)) {
                $this->Flash->success(__('The claim has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The claim could not be saved. Please, try again.'));
        }
        $this->set(compact('claim'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Claim id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $claim = $this->Claims->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $claim = $this->Claims->patchEntity($claim, $this->request->getData());
            if ($this->Claims->save($claim)) {
                $this->Flash->success(__('The claim has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The claim could not be saved. Please, try again.'));
        }
        $this->set(compact('claim'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Claim id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $claim = $this->Claims->get($id);
        if ($this->Claims->delete($claim)) {
            $this->Flash->success(__('The claim has been deleted.'));
        } else {
            $this->Flash->error(__('The claim could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
