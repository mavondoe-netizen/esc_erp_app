<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Requisitions Controller
 *
 * @property \App\Model\Table\RequisitionsTable $Requisitions
 */
class RequisitionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Requisitions->find()
            ->contain(['Departments', 'Users', 'Companies']);
        $requisitions = $this->paginate($query);

        $this->set(compact('requisitions'));
    }

    /**
     * View method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requisition = $this->Requisitions->get($id, contain: ['Departments', 'Users', 'Companies', 'Procurements', 'RequisitionItems']);
        $this->set(compact('requisition'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requisition = $this->Requisitions->newEmptyEntity();
        if ($this->request->is('post')) {
            $requisition = $this->Requisitions->patchEntity($requisition, $this->request->getData());
            if ($this->Requisitions->save($requisition)) {
                $this->Flash->success(__('The requisition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requisition could not be saved. Please, try again.'));
        }
        $departments = $this->Requisitions->Departments->find('list', limit: 200)->all();
        $users = $this->Requisitions->Users->find('list', limit: 200)->all();
        $companies = $this->Requisitions->Companies->find('list', limit: 200)->all();
        $this->set(compact('requisition', 'departments', 'users', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requisition = $this->Requisitions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requisition = $this->Requisitions->patchEntity($requisition, $this->request->getData());
            if ($this->Requisitions->save($requisition)) {
                $this->Flash->success(__('The requisition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requisition could not be saved. Please, try again.'));
        }
        $departments = $this->Requisitions->Departments->find('list', limit: 200)->all();
        $users = $this->Requisitions->Users->find('list', limit: 200)->all();
        $companies = $this->Requisitions->Companies->find('list', limit: 200)->all();
        $this->set(compact('requisition', 'departments', 'users', 'companies'));
    }

    /**
     * Submit method - triggers the approval workflow.
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function submit($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $requisition = $this->Requisitions->get($id);
        
        if ($requisition->status !== 'Draft' && $requisition->status !== 'Rejected') {
            $this->Flash->error(__('Requisition is already submitted or processed.'));
            return $this->redirect(['action' => 'index']);
        }

        $requisition->status = 'Submitted';
        if ($this->Requisitions->save($requisition)) {
            $approvalService = new \App\Service\ApprovalService();
            $userId = $this->Authentication->getIdentity()->get('id');
            
            if ($approvalService->start('Requisitions', (int)$requisition->id, (int)$userId)) {
                $this->Flash->success(__('The requisition has been submitted for approval.'));
            } else {
                $this->Flash->error(__('Requisition saved but approval workflow failed to start.'));
            }
        } else {
            $this->Flash->error(__('The requisition could not be submitted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Requisition id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requisition = $this->Requisitions->get($id);
        if ($this->Requisitions->delete($requisition)) {
            $this->Flash->success(__('The requisition has been deleted.'));
        } else {
            $this->Flash->error(__('The requisition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
