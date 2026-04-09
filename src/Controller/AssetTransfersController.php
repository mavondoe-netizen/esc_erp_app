<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AssetTransfers Controller
 *
 * @property \App\Model\Table\AssetTransfersTable $AssetTransfers
 */
class AssetTransfersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AssetTransfers->find()
            ->contain(['Companies', 'Assets']);
        $assetTransfers = $this->paginate($query);

        $this->set(compact('assetTransfers'));
    }

    /**
     * View method
     *
     * @param string|null $id Asset Transfer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assetTransfer = $this->AssetTransfers->get($id, contain: ['Companies', 'Assets']);
        $this->set(compact('assetTransfer'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assetTransfer = $this->AssetTransfers->newEmptyEntity();
        if ($this->request->is('post')) {
            $assetTransfer = $this->AssetTransfers->patchEntity($assetTransfer, $this->request->getData());
            if ($this->AssetTransfers->save($assetTransfer)) {
                $this->Flash->success(__('The asset transfer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset transfer could not be saved. Please, try again.'));
        }
        $companies = $this->AssetTransfers->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetTransfers->Assets->find('list', limit: 200)->all();
        $this->set(compact('assetTransfer', 'companies', 'assets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Asset Transfer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assetTransfer = $this->AssetTransfers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assetTransfer = $this->AssetTransfers->patchEntity($assetTransfer, $this->request->getData());
            if ($this->AssetTransfers->save($assetTransfer)) {
                $this->Flash->success(__('The asset transfer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset transfer could not be saved. Please, try again.'));
        }
        $companies = $this->AssetTransfers->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetTransfers->Assets->find('list', limit: 200)->all();
        $this->set(compact('assetTransfer', 'companies', 'assets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset Transfer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assetTransfer = $this->AssetTransfers->get($id);
        if ($this->AssetTransfers->delete($assetTransfer)) {
            $this->Flash->success(__('The asset transfer has been deleted.'));
        } else {
            $this->Flash->error(__('The asset transfer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
