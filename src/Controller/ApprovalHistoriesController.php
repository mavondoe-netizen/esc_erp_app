<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ApprovalHistories Controller
 *
 * @property \App\Model\Table\ApprovalHistoriesTable $ApprovalHistories
 */
class ApprovalHistoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ApprovalHistories->find()
            ->contain(['Approvals']);
        $approvalHistories = $this->paginate($query);

        $this->set(compact('approvalHistories'));
    }

    /**
     * View method
     *
     * @param string|null $id Approval History id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $approvalHistory = $this->ApprovalHistories->get($id, contain: ['Approvals']);
        $this->set(compact('approvalHistory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $approvalHistory = $this->ApprovalHistories->newEmptyEntity();
        if ($this->request->is('post')) {
            $approvalHistory = $this->ApprovalHistories->patchEntity($approvalHistory, $this->request->getData());
            if ($this->ApprovalHistories->save($approvalHistory)) {
                $this->Flash->success(__('The approval history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval history could not be saved. Please, try again.'));
        }
        $approvals = $this->ApprovalHistories->Approvals->find('list', limit: 200)->all();
        $this->set(compact('approvalHistory', 'approvals'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Approval History id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $approvalHistory = $this->ApprovalHistories->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $approvalHistory = $this->ApprovalHistories->patchEntity($approvalHistory, $this->request->getData());
            if ($this->ApprovalHistories->save($approvalHistory)) {
                $this->Flash->success(__('The approval history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval history could not be saved. Please, try again.'));
        }
        $approvals = $this->ApprovalHistories->Approvals->find('list', limit: 200)->all();
        $this->set(compact('approvalHistory', 'approvals'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Approval History id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $approvalHistory = $this->ApprovalHistories->get($id);
        if ($this->ApprovalHistories->delete($approvalHistory)) {
            $this->Flash->success(__('The approval history has been deleted.'));
        } else {
            $this->Flash->error(__('The approval history could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
