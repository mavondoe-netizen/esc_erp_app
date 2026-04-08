<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Kris Controller
 *
 * @property \App\Model\Table\KrisTable $Kris
 */
class KrisController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Kris->find()
            ->contain(['Companies', 'Risks']);
        $kris = $this->paginate($query);

        $this->set(compact('kris'));
    }

    /**
     * View method
     *
     * @param string|null $id Kri id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $kri = $this->Kris->get($id, contain: ['Companies', 'Risks']);
        $this->set(compact('kri'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $kri = $this->Kris->newEmptyEntity();
        if ($this->request->is('post')) {
            $kri = $this->Kris->patchEntity($kri, $this->request->getData());
            if ($this->Kris->save($kri)) {
                $this->Flash->success(__('The kri has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kri could not be saved. Please, try again.'));
        }
        $companies = $this->Kris->Companies->find('list', limit: 200)->all();
        $risks = $this->Kris->Risks->find('list', limit: 200)->all();
        $this->set(compact('kri', 'companies', 'risks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Kri id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $kri = $this->Kris->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $kri = $this->Kris->patchEntity($kri, $this->request->getData());
            if ($this->Kris->save($kri)) {
                $this->Flash->success(__('The kri has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The kri could not be saved. Please, try again.'));
        }
        $companies = $this->Kris->Companies->find('list', limit: 200)->all();
        $risks = $this->Kris->Risks->find('list', limit: 200)->all();
        $this->set(compact('kri', 'companies', 'risks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Kri id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $kri = $this->Kris->get($id);
        if ($this->Kris->delete($kri)) {
            $this->Flash->success(__('The kri has been deleted.'));
        } else {
            $this->Flash->error(__('The kri could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
