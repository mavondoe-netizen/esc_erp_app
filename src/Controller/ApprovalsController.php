<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Approvals Controller
 *
 * @property \App\Model\Table\ApprovalsTable $Approvals
 */
class ApprovalsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Approvals->find();
        $approvals = $this->paginate($query);

        $this->set(compact('approvals'));
    }

    /**
     * View method
     *
     * @param string|null $id Approval id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $approval = $this->Approvals->get($id, contain: []);
        $this->set(compact('approval'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $approval = $this->Approvals->newEmptyEntity();
        if ($this->request->is('post')) {
            $approval = $this->Approvals->patchEntity($approval, $this->request->getData());
            if ($this->Approvals->save($approval)) {
                $this->Flash->success(__('The approval has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval could not be saved. Please, try again.'));
        }
        $this->set(compact('approval'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Approval id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $approval = $this->Approvals->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $approval = $this->Approvals->patchEntity($approval, $this->request->getData());
            if ($this->Approvals->save($approval)) {
                $this->Flash->success(__('The approval has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval could not be saved. Please, try again.'));
        }
        $this->set(compact('approval'));
    }

    /**
     * Approve method
     *
     * @param string|null $id Approval id.
     * @return \Cake\Http\Response|null Redirects to referer.
     */
    public function approve($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $approval = $this->Approvals->get($id);
        
        $approval->status = 'Approved';
        
        if ($this->Approvals->save($approval)) {
            $approvalService = new \App\Service\ApprovalService();
            $userId = $this->Authentication->getIdentity()->get('id');
            
            if ($approvalService->progress((int)$approval->id, (int)$userId, 'Approved', (string)$this->request->getData('remarks'))) {
                $this->Flash->success(__('The approval has been processed.'));
            } else {
                $this->Flash->error(__('Approval record updated, but workflow progression failed.'));
            }
        } else {
            $this->Flash->error(__('The approval could not be saved. Please, try again.'));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Reject method
     *
     * @param string|null $id Approval id.
     * @return \Cake\Http\Response|null Redirects to referer.
     */
    public function reject($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $approval = $this->Approvals->get($id);
        
        $approval->status = 'Rejected';
        
        if ($this->Approvals->save($approval)) {
            $approvalService = new \App\Service\ApprovalService();
            $userId = $this->Authentication->getIdentity()->get('id');
            
            if ($approvalService->progress((int)$approval->id, (int)$userId, 'Rejected', (string)$this->request->getData('remarks'))) {
                $this->Flash->success(__('The approval has been rejected.'));
            } else {
                $this->Flash->error(__('Approval record updated, but rejection progression failed.'));
            }
        } else {
            $this->Flash->error(__('The approval could not be rejected. Please, try again.'));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Delete method
     *
     * @param string|null $id Approval id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $approval = $this->Approvals->get($id);
        if ($this->Approvals->delete($approval)) {
            $this->Flash->success(__('The approval has been deleted.'));
        } else {
            $this->Flash->error(__('The approval could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
