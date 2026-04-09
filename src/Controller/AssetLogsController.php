<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AssetLogs Controller
 *
 * @property \App\Model\Table\AssetLogsTable $AssetLogs
 */
class AssetLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AssetLogs->find()
            ->contain(['Companies', 'Assets', 'Users']);
        $assetLogs = $this->paginate($query);

        $this->set(compact('assetLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Asset Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assetLog = $this->AssetLogs->get($id, contain: ['Companies', 'Assets', 'Users']);
        $this->set(compact('assetLog'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assetLog = $this->AssetLogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $assetLog = $this->AssetLogs->patchEntity($assetLog, $this->request->getData());
            if ($this->AssetLogs->save($assetLog)) {
                $this->Flash->success(__('The asset log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset log could not be saved. Please, try again.'));
        }
        $companies = $this->AssetLogs->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetLogs->Assets->find('list', limit: 200)->all();
        $users = $this->AssetLogs->Users->find('list', limit: 200)->all();
        $this->set(compact('assetLog', 'companies', 'assets', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Asset Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assetLog = $this->AssetLogs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assetLog = $this->AssetLogs->patchEntity($assetLog, $this->request->getData());
            if ($this->AssetLogs->save($assetLog)) {
                $this->Flash->success(__('The asset log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset log could not be saved. Please, try again.'));
        }
        $companies = $this->AssetLogs->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetLogs->Assets->find('list', limit: 200)->all();
        $users = $this->AssetLogs->Users->find('list', limit: 200)->all();
        $this->set(compact('assetLog', 'companies', 'assets', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assetLog = $this->AssetLogs->get($id);
        if ($this->AssetLogs->delete($assetLog)) {
            $this->Flash->success(__('The asset log has been deleted.'));
        } else {
            $this->Flash->error(__('The asset log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
