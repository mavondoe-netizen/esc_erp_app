<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ApprovalLevels Controller
 *
 * @property \App\Model\Table\ApprovalLevelsTable $ApprovalLevels
 */
class ApprovalLevelsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('ApprovalLevels')->find();
        $approvalLevels = $this->paginate($query);

        $this->set(compact('approvalLevels'));
    }

    /**
     * View method
     *
     * @param string|null $id Approval Level id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $approvalLevel = $this->fetchTable('ApprovalLevels')->get($id, contain: []);
        $this->set(compact('approvalLevel'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $approvalLevel = $this->fetchTable('ApprovalLevels')->newEmptyEntity();
        if ($this->request->is('post')) {
            $approvalLevel = $this->fetchTable('ApprovalLevels')->patchEntity($approvalLevel, $this->request->getData());
            if ($this->fetchTable('ApprovalLevels')->save($approvalLevel)) {
                $this->Flash->success(__('The approval level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval level could not be saved. Please, try again.'));
        }
        $this->set(compact('approvalLevel'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Approval Level id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $approvalLevel = $this->fetchTable('ApprovalLevels')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $approvalLevel = $this->fetchTable('ApprovalLevels')->patchEntity($approvalLevel, $this->request->getData());
            if ($this->fetchTable('ApprovalLevels')->save($approvalLevel)) {
                $this->Flash->success(__('The approval level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The approval level could not be saved. Please, try again.'));
        }
        $this->set(compact('approvalLevel'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Approval Level id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $approvalLevel = $this->fetchTable('ApprovalLevels')->get($id);
        if ($this->fetchTable('ApprovalLevels')->delete($approvalLevel)) {
            $this->Flash->success(__('The approval level has been deleted.'));
        } else {
            $this->Flash->error(__('The approval level could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
