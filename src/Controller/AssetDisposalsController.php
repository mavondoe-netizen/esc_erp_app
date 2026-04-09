<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AssetDisposals Controller
 *
 * @property \App\Model\Table\AssetDisposalsTable $AssetDisposals
 */
class AssetDisposalsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AssetDisposals->find()
            ->contain(['Companies', 'Assets']);
        $assetDisposals = $this->paginate($query);

        $this->set(compact('assetDisposals'));
    }

    /**
     * View method
     *
     * @param string|null $id Asset Disposal id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assetDisposal = $this->AssetDisposals->get($id, contain: ['Companies', 'Assets']);
        $this->set(compact('assetDisposal'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assetDisposal = $this->AssetDisposals->newEmptyEntity();
        if ($this->request->is('post')) {
            $assetDisposal = $this->AssetDisposals->patchEntity($assetDisposal, $this->request->getData());
            if ($this->AssetDisposals->save($assetDisposal)) {
                $this->Flash->success(__('The asset disposal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset disposal could not be saved. Please, try again.'));
        }
        $companies = $this->AssetDisposals->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetDisposals->Assets->find('list', limit: 200)->all();
        $this->set(compact('assetDisposal', 'companies', 'assets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Asset Disposal id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assetDisposal = $this->AssetDisposals->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assetDisposal = $this->AssetDisposals->patchEntity($assetDisposal, $this->request->getData());
            if ($this->AssetDisposals->save($assetDisposal)) {
                $this->Flash->success(__('The asset disposal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset disposal could not be saved. Please, try again.'));
        }
        $companies = $this->AssetDisposals->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetDisposals->Assets->find('list', limit: 200)->all();
        $this->set(compact('assetDisposal', 'companies', 'assets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset Disposal id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assetDisposal = $this->AssetDisposals->get($id);
        if ($this->AssetDisposals->delete($assetDisposal)) {
            $this->Flash->success(__('The asset disposal has been deleted.'));
        } else {
            $this->Flash->error(__('The asset disposal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
