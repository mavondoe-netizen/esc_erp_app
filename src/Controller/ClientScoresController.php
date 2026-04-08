<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ClientScores Controller
 *
 * @property \App\Model\Table\ClientScoresTable $ClientScores
 */
class ClientScoresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ClientScores->find();
        $clientScores = $this->paginate($query);

        $this->set(compact('clientScores'));
    }

    /**
     * View method
     *
     * @param string|null $id Client Score id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientScore = $this->ClientScores->get($id, contain: []);
        $this->set(compact('clientScore'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientScore = $this->ClientScores->newEmptyEntity();
        if ($this->request->is('post')) {
            $clientScore = $this->ClientScores->patchEntity($clientScore, $this->request->getData());
            if ($this->ClientScores->save($clientScore)) {
                $this->Flash->success(__('The client score has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client score could not be saved. Please, try again.'));
        }
        $this->set(compact('clientScore'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Score id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientScore = $this->ClientScores->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientScore = $this->ClientScores->patchEntity($clientScore, $this->request->getData());
            if ($this->ClientScores->save($clientScore)) {
                $this->Flash->success(__('The client score has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client score could not be saved. Please, try again.'));
        }
        $this->set(compact('clientScore'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Score id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientScore = $this->ClientScores->get($id);
        if ($this->ClientScores->delete($clientScore)) {
            $this->Flash->success(__('The client score has been deleted.'));
        } else {
            $this->Flash->error(__('The client score could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
