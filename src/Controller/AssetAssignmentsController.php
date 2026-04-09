<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AssetAssignments Controller
 *
 * @property \App\Model\Table\AssetAssignmentsTable $AssetAssignments
 */
class AssetAssignmentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AssetAssignments->find()
            ->contain(['Companies', 'Assets', 'Offices', 'Departments']);
        $assetAssignments = $this->paginate($query);

        $this->set(compact('assetAssignments'));
    }

    /**
     * View method
     *
     * @param string|null $id Asset Assignment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assetAssignment = $this->AssetAssignments->get($id, contain: ['Companies', 'Assets', 'Offices', 'Departments']);
        $this->set(compact('assetAssignment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assetAssignment = $this->AssetAssignments->newEmptyEntity();
        if ($this->request->is('post')) {
            $assetAssignment = $this->AssetAssignments->patchEntity($assetAssignment, $this->request->getData());
            if ($this->AssetAssignments->save($assetAssignment)) {
                $this->Flash->success(__('The asset assignment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset assignment could not be saved. Please, try again.'));
        }
        $companies = $this->AssetAssignments->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetAssignments->Assets->find('list', limit: 200)->all();
        $offices = $this->AssetAssignments->Offices->find('list', limit: 200)->all();
        $departments = $this->AssetAssignments->Departments->find('list', limit: 200)->all();
        $this->set(compact('assetAssignment', 'companies', 'assets', 'offices', 'departments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Asset Assignment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assetAssignment = $this->AssetAssignments->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assetAssignment = $this->AssetAssignments->patchEntity($assetAssignment, $this->request->getData());
            if ($this->AssetAssignments->save($assetAssignment)) {
                $this->Flash->success(__('The asset assignment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The asset assignment could not be saved. Please, try again.'));
        }
        $companies = $this->AssetAssignments->Companies->find('list', limit: 200)->all();
        $assets = $this->AssetAssignments->Assets->find('list', limit: 200)->all();
        $offices = $this->AssetAssignments->Offices->find('list', limit: 200)->all();
        $departments = $this->AssetAssignments->Departments->find('list', limit: 200)->all();
        $this->set(compact('assetAssignment', 'companies', 'assets', 'offices', 'departments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset Assignment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assetAssignment = $this->AssetAssignments->get($id);
        if ($this->AssetAssignments->delete($assetAssignment)) {
            $this->Flash->success(__('The asset assignment has been deleted.'));
        } else {
            $this->Flash->error(__('The asset assignment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
