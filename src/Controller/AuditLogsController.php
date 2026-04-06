<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AuditLogs Controller
 *
 * @property \App\Model\Table\AuditLogsTable $AuditLogs
 */
class AuditLogsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('AuditLogs')->find()
            ->contain(['Users']);
        $auditLogs = $this->paginate($query);

        $this->set(compact('auditLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Audit Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $auditLog = $this->fetchTable('AuditLogs')->get($id, contain: ['Users']);
        $this->set(compact('auditLog'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auditLog = $this->fetchTable('AuditLogs')->newEmptyEntity();
        if ($this->request->is('post')) {
            $auditLog = $this->fetchTable('AuditLogs')->patchEntity($auditLog, $this->request->getData());
            if ($this->fetchTable('AuditLogs')->save($auditLog)) {
                $this->Flash->success(__('The audit log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit log could not be saved. Please, try again.'));
        }
        $users = $this->fetchTable('AuditLogs')->Users->find('list', limit: 200)->all();
        $this->set(compact('auditLog', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Audit Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $auditLog = $this->fetchTable('AuditLogs')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auditLog = $this->fetchTable('AuditLogs')->patchEntity($auditLog, $this->request->getData());
            if ($this->fetchTable('AuditLogs')->save($auditLog)) {
                $this->Flash->success(__('The audit log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit log could not be saved. Please, try again.'));
        }
        $users = $this->fetchTable('AuditLogs')->Users->find('list', limit: 200)->all();
        $this->set(compact('auditLog', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Audit Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $auditLog = $this->fetchTable('AuditLogs')->get($id);
        if ($this->fetchTable('AuditLogs')->delete($auditLog)) {
            $this->Flash->success(__('The audit log has been deleted.'));
        } else {
            $this->Flash->error(__('The audit log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
