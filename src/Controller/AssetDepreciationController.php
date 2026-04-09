<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AssetDepreciation Controller
 *
 * @property \App\Model\Table\AssetDepreciationTable $AssetDepreciation
 */
class AssetDepreciationController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AssetDepreciation->find()
            ->contain(['Companies', 'Assets']);
        $assetDepreciation = $this->paginate($query);

        $this->set(compact('assetDepreciation'));
    }

    /**
     * View method
     *
     * @param string|null $id Asset Depreciation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assetDepreciation = $this->AssetDepreciation->get($id, contain: ['Companies', 'Assets']);
        $this->set(compact('assetDepreciation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assetDepreciation = $this->AssetDepreciation->newEmptyEntity();
        if ($this->request->is('post')) {
            $assetDepreciation = $this->AssetDepreciation->patchEntity($assetDepreciation, $this->request->getData());
            if ($this->AssetDepreciation->save($assetDepreciation)) {
                $this->Flash->success(__('The asset depreciation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset depreciation could not be saved. Please, try again.'));
        }
        $companies = $this->AssetDepreciation->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetDepreciation->Assets->find('list', limit: 200)->all();
        $this->set(compact('assetDepreciation', 'companies', 'assets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Asset Depreciation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assetDepreciation = $this->AssetDepreciation->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assetDepreciation = $this->AssetDepreciation->patchEntity($assetDepreciation, $this->request->getData());
            if ($this->AssetDepreciation->save($assetDepreciation)) {
                $this->Flash->success(__('The asset depreciation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset depreciation could not be saved. Please, try again.'));
        }
        $companies = $this->AssetDepreciation->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetDepreciation->Assets->find('list', limit: 200)->all();
        $this->set(compact('assetDepreciation', 'companies', 'assets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset Depreciation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assetDepreciation = $this->AssetDepreciation->get($id);
        if ($this->AssetDepreciation->delete($assetDepreciation)) {
            $this->Flash->success(__('The asset depreciation has been deleted.'));
        } else {
            $this->Flash->error(__('The asset depreciation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
