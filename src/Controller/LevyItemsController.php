<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LevyItems Controller
 *
 * @property \App\Model\Table\LevyItemsTable $LevyItems
 */
class LevyItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LevyItems->find()
            ->contain(['Levies', 'Accounts', 'Products']);
        $levyItems = $this->paginate($query);

        $this->set(compact('levyItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Levy Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $levyItem = $this->LevyItems->get($id, contain: ['Levies', 'Accounts', 'Products']);
        $this->set(compact('levyItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $levyItem = $this->LevyItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $levyItem = $this->LevyItems->patchEntity($levyItem, $this->request->getData());
            if ($this->LevyItems->save($levyItem)) {
                $this->Flash->success(__('The levy item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The levy item could not be saved. Please, try again.'));
        }
        $levies   = $this->LevyItems->Levies->find('list', limit: 200)->all();
        $accounts = $this->LevyItems->Accounts->find('list', limit: 200)->all();
        $products = $this->LevyItems->Products->find('list', limit: 200)->all();
        $this->set(compact('levyItem', 'levies', 'accounts', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Levy Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $levyItem = $this->LevyItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $levyItem = $this->LevyItems->patchEntity($levyItem, $this->request->getData());
            if ($this->LevyItems->save($levyItem)) {
                $this->Flash->success(__('The levy item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The levy item could not be saved. Please, try again.'));
        }
        $levies   = $this->LevyItems->Levies->find('list', limit: 200)->all();
        $accounts = $this->LevyItems->Accounts->find('list', limit: 200)->all();
        $products = $this->LevyItems->Products->find('list', limit: 200)->all();
        $this->set(compact('levyItem', 'levies', 'accounts', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Levy Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $levyItem = $this->LevyItems->get($id);
        if ($this->LevyItems->delete($levyItem)) {
            $this->Flash->success(__('The levy item has been deleted.'));
        } else {
            $this->Flash->error(__('The levy item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
