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
        $query = $this->AuditLogs->find()
            ->contain(['Companies']);
        $auditLogs = $this->paginate($query);

        // Manually resolve user emails cross-tenant
        $userIds = array_filter(array_unique(
            array_map(fn($log) => $log->user_id, $auditLogs->toArray())
        ));
        $usersMap = [];
        if (!empty($userIds)) {
            $usersMap = $this->fetchTable('Users')
                ->find('all', ignoreTenant: true)
                ->where(['Users.id IN' => $userIds])
                ->all()
                ->combine('id', function ($u) { return $u; })
                ->toArray();
        }

        $this->set(compact('auditLogs', 'usersMap'));
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
        $auditLog = $this->AuditLogs->get($id, contain: ['Companies']);

        // Manually resolve user cross-tenant
        $user = null;
        if ($auditLog->user_id) {
            $user = $this->fetchTable('Users')
                ->find('all', ignoreTenant: true)
                ->where(['Users.id' => $auditLog->user_id])
                ->first();
        }

        $this->set(compact('auditLog', 'user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auditLog = $this->AuditLogs->newEmptyEntity();
        if ($this->request->is('post')) {
            $auditLog = $this->AuditLogs->patchEntity($auditLog, $this->request->getData());
            if ($this->AuditLogs->save($auditLog)) {
                $this->Flash->success(__('The audit log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit log could not be saved. Please, try again.'));
        }
        $users = $this->AuditLogs->Users->find('list', limit: 200)->all();
        $companies = $this->AuditLogs->Companies->find('list', limit: 200)->all();
        $this->set(compact('auditLog', 'users', 'companies'));
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
        $auditLog = $this->AuditLogs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auditLog = $this->AuditLogs->patchEntity($auditLog, $this->request->getData());
            if ($this->AuditLogs->save($auditLog)) {
                $this->Flash->success(__('The audit log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit log could not be saved. Please, try again.'));
        }
        $users = $this->AuditLogs->Users->find('list', limit: 200)->all();
        $companies = $this->AuditLogs->Companies->find('list', limit: 200)->all();
        $this->set(compact('auditLog', 'users', 'companies'));
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
        $auditLog = $this->AuditLogs->get($id);
        if ($this->AuditLogs->delete($auditLog)) {
            $this->Flash->success(__('The audit log has been deleted.'));
        } else {
            $this->Flash->error(__('The audit log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
