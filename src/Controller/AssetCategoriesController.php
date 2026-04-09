<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AssetCategories Controller
 *
 * @property \App\Model\Table\AssetCategoriesTable $AssetCategories
 */
class AssetCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AssetCategories->find()
            ->contain(['Companies']);
        $assetCategories = $this->paginate($query);

        $this->set(compact('assetCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Asset Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assetCategory = $this->AssetCategories->get($id, contain: ['Companies']);
        $this->set(compact('assetCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assetCategory = $this->AssetCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $assetCategory = $this->AssetCategories->patchEntity($assetCategory, $this->request->getData());
            if ($this->AssetCategories->save($assetCategory)) {
                $this->Flash->success(__('The asset category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset category could not be saved. Please, try again.'));
        }
        $companies = $this->AssetCategories->Companies->find('list', limit: 200)->all();
        $this->set(compact('assetCategory', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Asset Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assetCategory = $this->AssetCategories->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assetCategory = $this->AssetCategories->patchEntity($assetCategory, $this->request->getData());
            if ($this->AssetCategories->save($assetCategory)) {
                $this->Flash->success(__('The asset category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset category could not be saved. Please, try again.'));
        }
        $companies = $this->AssetCategories->Companies->find('list', limit: 200)->all();
        $this->set(compact('assetCategory', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assetCategory = $this->AssetCategories->get($id);
        if ($this->AssetCategories->delete($assetCategory)) {
            $this->Flash->success(__('The asset category has been deleted.'));
        } else {
            $this->Flash->error(__('The asset category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
