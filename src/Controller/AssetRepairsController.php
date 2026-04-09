<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AssetRepairs Controller
 *
 * @property \App\Model\Table\AssetRepairsTable $AssetRepairs
 */
class AssetRepairsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AssetRepairs->find()
            ->contain(['Companies', 'Assets']);
        $assetRepairs = $this->paginate($query);

        $this->set(compact('assetRepairs'));
    }

    /**
     * View method
     *
     * @param string|null $id Asset Repair id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assetRepair = $this->AssetRepairs->get($id, contain: ['Companies', 'Assets']);
        $this->set(compact('assetRepair'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assetRepair = $this->AssetRepairs->newEmptyEntity();
        if ($this->request->is('post')) {
            $assetRepair = $this->AssetRepairs->patchEntity($assetRepair, $this->request->getData());
            if ($this->AssetRepairs->save($assetRepair)) {
                $this->Flash->success(__('The asset repair has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset repair could not be saved. Please, try again.'));
        }
        $companies = $this->AssetRepairs->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetRepairs->Assets->find('list', limit: 200)->all();
        $this->set(compact('assetRepair', 'companies', 'assets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Asset Repair id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assetRepair = $this->AssetRepairs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assetRepair = $this->AssetRepairs->patchEntity($assetRepair, $this->request->getData());
            if ($this->AssetRepairs->save($assetRepair)) {
                $this->Flash->success(__('The asset repair has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset repair could not be saved. Please, try again.'));
        }
        $companies = $this->AssetRepairs->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetRepairs->Assets->find('list', limit: 200)->all();
        $this->set(compact('assetRepair', 'companies', 'assets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset Repair id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assetRepair = $this->AssetRepairs->get($id);
        if ($this->AssetRepairs->delete($assetRepair)) {
            $this->Flash->success(__('The asset repair has been deleted.'));
        } else {
            $this->Flash->error(__('The asset repair could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
