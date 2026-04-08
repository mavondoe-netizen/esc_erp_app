<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AuditActions Controller
 *
 * @property \App\Model\Table\AuditActionsTable $AuditActions
 */
class AuditActionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AuditActions->find()
            ->contain(['Companies']);
        $auditActions = $this->paginate($query);

        $this->set(compact('auditActions'));
    }

    /**
     * View method
     *
     * @param string|null $id Audit Action id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $auditAction = $this->AuditActions->get($id, contain: ['Companies']);
        $this->set(compact('auditAction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auditAction = $this->AuditActions->newEmptyEntity();
        if ($this->request->is('post')) {
            $auditAction = $this->AuditActions->patchEntity($auditAction, $this->request->getData());
            if ($this->AuditActions->save($auditAction)) {
                $this->Flash->success(__('The audit action has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit action could not be saved. Please, try again.'));
        }
        $companies = $this->AuditActions->Companies->find('list', limit: 200)->all();
        $this->set(compact('auditAction', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Audit Action id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $auditAction = $this->AuditActions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auditAction = $this->AuditActions->patchEntity($auditAction, $this->request->getData());
            if ($this->AuditActions->save($auditAction)) {
                $this->Flash->success(__('The audit action has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit action could not be saved. Please, try again.'));
        }
        $companies = $this->AuditActions->Companies->find('list', limit: 200)->all();
        $this->set(compact('auditAction', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Audit Action id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $auditAction = $this->AuditActions->get($id);
        if ($this->AuditActions->delete($auditAction)) {
            $this->Flash->success(__('The audit action has been deleted.'));
        } else {
            $this->Flash->error(__('The audit action could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
