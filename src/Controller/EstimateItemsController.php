<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * EstimateItems Controller
 *
 * @property \App\Model\Table\EstimateItemsTable $EstimateItems
 */
class EstimateItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->EstimateItems->find()
            ->contain(['Estimates', 'Products', 'Accounts']);
        $estimateItems = $this->paginate($query);

        $this->set(compact('estimateItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Estimate Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estimateItem = $this->EstimateItems->get($id, contain: ['Estimates', 'Products', 'Accounts']);
        $this->set(compact('estimateItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estimateItem = $this->EstimateItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $estimateItem = $this->EstimateItems->patchEntity($estimateItem, $this->request->getData());
            if ($this->EstimateItems->save($estimateItem)) {
                $this->Flash->success(__('The estimate item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estimate item could not be saved. Please, try again.'));
        }
        $estimates = $this->EstimateItems->Estimates->find('list', limit: 200)->all();
        $products = $this->EstimateItems->Products->find('list', limit: 200)->all();
        $accounts = $this->EstimateItems->Accounts->find('list', limit: 200)->all();
        $this->set(compact('estimateItem', 'estimates', 'products', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estimate Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estimateItem = $this->EstimateItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estimateItem = $this->EstimateItems->patchEntity($estimateItem, $this->request->getData());
            if ($this->EstimateItems->save($estimateItem)) {
                $this->Flash->success(__('The estimate item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estimate item could not be saved. Please, try again.'));
        }
        $estimates = $this->EstimateItems->Estimates->find('list', limit: 200)->all();
        $products = $this->EstimateItems->Products->find('list', limit: 200)->all();
        $accounts = $this->EstimateItems->Accounts->find('list', limit: 200)->all();
        $this->set(compact('estimateItem', 'estimates', 'products', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estimate Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estimateItem = $this->EstimateItems->get($id);
        if ($this->EstimateItems->delete($estimateItem)) {
            $this->Flash->success(__('The estimate item has been deleted.'));
        } else {
            $this->Flash->error(__('The estimate item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
