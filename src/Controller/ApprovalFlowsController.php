<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ApprovalFlows Controller
 *
 * @property \App\Model\Table\ApprovalFlowsTable $ApprovalFlows
 */
class ApprovalFlowsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ApprovalFlows->find()
            ->contain(['Roles']);
        $approvalFlows = $this->paginate($query);

        $this->set(compact('approvalFlows'));
    }

    /**
     * View method
     *
     * @param string|null $id Approval Flow id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $approvalFlow = $this->ApprovalFlows->get($id, contain: ['Roles']);
        $this->set(compact('approvalFlow'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $approvalFlow = $this->ApprovalFlows->newEmptyEntity();
        if ($this->request->is('post')) {
            $approvalFlow = $this->ApprovalFlows->patchEntity($approvalFlow, $this->request->getData());
            if ($this->ApprovalFlows->save($approvalFlow)) {
                $this->Flash->success(__('The approval flow has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval flow could not be saved. Please, try again.'));
        }
        $roles = $this->ApprovalFlows->Roles->find('list', limit: 200)->all();
        $this->set(compact('approvalFlow', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Approval Flow id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $approvalFlow = $this->ApprovalFlows->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $approvalFlow = $this->ApprovalFlows->patchEntity($approvalFlow, $this->request->getData());
            if ($this->ApprovalFlows->save($approvalFlow)) {
                $this->Flash->success(__('The approval flow has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval flow could not be saved. Please, try again.'));
        }
        $roles = $this->ApprovalFlows->Roles->find('list', limit: 200)->all();
        $this->set(compact('approvalFlow', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Approval Flow id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $approvalFlow = $this->ApprovalFlows->get($id);
        if ($this->ApprovalFlows->delete($approvalFlow)) {
            $this->Flash->success(__('The approval flow has been deleted.'));
        } else {
            $this->Flash->error(__('The approval flow could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
