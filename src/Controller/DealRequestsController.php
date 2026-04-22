<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DealRequests Controller
 *
 * @property \App\Model\Table\DealRequestsTable $DealRequests
 */
class DealRequestsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->DealRequests->find()
            ->contain(['Companies', 'Deals']);
        $dealRequests = $this->paginate($query);

        $this->set(compact('dealRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Deal Request id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dealRequest = $this->DealRequests->get($id, contain: ['Companies', 'Deals']);
        $this->set(compact('dealRequest'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dealRequest = $this->DealRequests->newEmptyEntity();
        if ($this->request->is('post')) {
            $dealRequest = $this->DealRequests->patchEntity($dealRequest, $this->request->getData());
            if ($this->DealRequests->save($dealRequest)) {
                $this->Flash->success(__('The deal request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deal request could not be saved. Please, try again.'));
        }
        $companies = $this->DealRequests->Companies->find('list', limit: 200)->all();
        $deals = $this->DealRequests->Deals->find('list', limit: 200)->all();
        $this->set(compact('dealRequest', 'companies', 'deals'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Deal Request id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dealRequest = $this->DealRequests->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dealRequest = $this->DealRequests->patchEntity($dealRequest, $this->request->getData());
            if ($this->DealRequests->save($dealRequest)) {
                $this->Flash->success(__('The deal request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deal request could not be saved. Please, try again.'));
        }
        $companies = $this->DealRequests->Companies->find('list', limit: 200)->all();
        $deals = $this->DealRequests->Deals->find('list', limit: 200)->all();
        $this->set(compact('dealRequest', 'companies', 'deals'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Deal Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dealRequest = $this->DealRequests->get($id);
        if ($this->DealRequests->delete($dealRequest)) {
            $this->Flash->success(__('The deal request has been deleted.'));
        } else {
            $this->Flash->error(__('The deal request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
