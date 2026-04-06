<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AuditTrails Controller
 *
 * @property \App\Model\Table\AuditTrailsTable $AuditTrails
 */
class AuditTrailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('AuditTrails')->find()
            ->contain(['Users']);
        $auditTrails = $this->paginate($query);

        $this->set(compact('auditTrails'));
    }

    /**
     * View method
     *
     * @param string|null $id Audit Trail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $auditTrail = $this->fetchTable('AuditTrails')->get($id, contain: ['Users']);
        $this->set(compact('auditTrail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auditTrail = $this->fetchTable('AuditTrails')->newEmptyEntity();
        if ($this->request->is('post')) {
            $auditTrail = $this->fetchTable('AuditTrails')->patchEntity($auditTrail, $this->request->getData());
            if ($this->fetchTable('AuditTrails')->save($auditTrail)) {
                $this->Flash->success(__('The audit trail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit trail could not be saved. Please, try again.'));
        }
        $users = $this->fetchTable('AuditTrails')->Users->find('list', limit: 200)->all();
        $this->set(compact('auditTrail', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Audit Trail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $auditTrail = $this->fetchTable('AuditTrails')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auditTrail = $this->fetchTable('AuditTrails')->patchEntity($auditTrail, $this->request->getData());
            if ($this->fetchTable('AuditTrails')->save($auditTrail)) {
                $this->Flash->success(__('The audit trail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit trail could not be saved. Please, try again.'));
        }
        $users = $this->fetchTable('AuditTrails')->Users->find('list', limit: 200)->all();
        $this->set(compact('auditTrail', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Audit Trail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $auditTrail = $this->fetchTable('AuditTrails')->get($id);
        if ($this->fetchTable('AuditTrails')->delete($auditTrail)) {
            $this->Flash->success(__('The audit trail has been deleted.'));
        } else {
            $this->Flash->error(__('The audit trail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
