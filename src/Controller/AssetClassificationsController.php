<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AssetClassifications Controller
 *
 * @property \App\Model\Table\AssetClassificationsTable $AssetClassifications
 */
class AssetClassificationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AssetClassifications->find()
            ->contain(['Companies']);
        $assetClassifications = $this->paginate($query);

        $this->set(compact('assetClassifications'));
    }

    /**
     * View method
     *
     * @param string|null $id Asset Classification id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assetClassification = $this->AssetClassifications->get($id, contain: ['Companies']);
        $this->set(compact('assetClassification'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assetClassification = $this->AssetClassifications->newEmptyEntity();
        if ($this->request->is('post')) {
            $assetClassification = $this->AssetClassifications->patchEntity($assetClassification, $this->request->getData());
            if ($this->AssetClassifications->save($assetClassification)) {
                $this->Flash->success(__('The asset classification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset classification could not be saved. Please, try again.'));
        }
        $companies = $this->AssetClassifications->Companies->find('list', limit: 200)->all();
        $this->set(compact('assetClassification', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Asset Classification id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assetClassification = $this->AssetClassifications->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assetClassification = $this->AssetClassifications->patchEntity($assetClassification, $this->request->getData());
            if ($this->AssetClassifications->save($assetClassification)) {
                $this->Flash->success(__('The asset classification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset classification could not be saved. Please, try again.'));
        }
        $companies = $this->AssetClassifications->Companies->find('list', limit: 200)->all();
        $this->set(compact('assetClassification', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset Classification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assetClassification = $this->AssetClassifications->get($id);
        if ($this->AssetClassifications->delete($assetClassification)) {
            $this->Flash->success(__('The asset classification has been deleted.'));
        } else {
            $this->Flash->error(__('The asset classification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
