<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Awards Controller
 *
 * @property \App\Model\Table\AwardsTable $Awards
 */
class AwardsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Awards->find()
            ->contain(['Tenders', 'Suppliers', 'Companies']);
        $awards = $this->paginate($query);

        $this->set(compact('awards'));
    }

    /**
     * View method
     *
     * @param string|null $id Award id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $award = $this->Awards->get($id, contain: ['Tenders', 'Suppliers', 'Companies', 'Bills', 'Contracts']);
        $this->set(compact('award'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $award = $this->Awards->newEmptyEntity();
        if ($this->request->is('post')) {
            $award = $this->Awards->patchEntity($award, $this->request->getData());
            if ($this->Awards->save($award)) {
                $this->Flash->success(__('The award has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The award could not be saved. Please, try again.'));
        }
        $tenders = $this->Awards->Tenders->find('list', limit: 200)->all();
        $suppliers = $this->Awards->Suppliers->find('list', limit: 200)->all();
        $companies = $this->Awards->Companies->find('list', limit: 200)->all();
        $this->set(compact('award', 'tenders', 'suppliers', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Award id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $award = $this->Awards->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $award = $this->Awards->patchEntity($award, $this->request->getData());
            if ($this->Awards->save($award)) {
                $this->Flash->success(__('The award has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The award could not be saved. Please, try again.'));
        }
        $tenders = $this->Awards->Tenders->find('list', limit: 200)->all();
        $suppliers = $this->Awards->Suppliers->find('list', limit: 200)->all();
        $companies = $this->Awards->Companies->find('list', limit: 200)->all();
        $this->set(compact('award', 'tenders', 'suppliers', 'companies'));
    }

    /**
     * Submit method - triggers the approval workflow.
     *
     * @param string|null $id Award id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function submit($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $award = $this->Awards->get($id);
        
        if ($award->status !== 'Draft' && $award->status !== 'Pending') {
            $this->Flash->error(__('Award is already submitted or processed.'));
            return $this->redirect(['action' => 'index']);
        }

        $award->status = 'Submitted';
        if ($this->Awards->save($award)) {
            $approvalService = new \App\Service\ApprovalService();
            $userId = $this->Authentication->getIdentity()->get('id');
            
            if ($approvalService->start('Awards', (int)$award->id, (int)$userId)) {
                $this->Flash->success(__('The award has been submitted for approval.'));
            } else {
                $this->Flash->error(__('Award saved but approval workflow failed to start.'));
            }
        } else {
            $this->Flash->error(__('The award could not be submitted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Award id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $award = $this->Awards->get($id);
        if ($this->Awards->delete($award)) {
            $this->Flash->success(__('The award has been deleted.'));
        } else {
            $this->Flash->error(__('The award could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
