<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Permissions Controller
 *
 * @property \App\Model\Table\PermissionsTable $Permissions
 */
class PermissionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Permissions')->find()
            ->contain(['Roles']);
        $permissions = $this->paginate($query);

        $this->set(compact('permissions'));
    }

    /**
     * View method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $permission = $this->fetchTable('Permissions')->get($id, contain: ['Roles']);
        $this->set(compact('permission'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $permission = $this->fetchTable('Permissions')->newEmptyEntity();
        if ($this->request->is('post')) {
            $permission = $this->fetchTable('Permissions')->patchEntity($permission, $this->request->getData());
            if ($this->fetchTable('Permissions')->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permission could not be saved. Please, try again.'));
        }
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $tables = $conn->getSchemaCollection()->listTables();
        $excluded = ['phinxlog', 'sessions', 'audit_logs'];
        
        $modelsOptions = [];
        foreach (array_diff($tables, $excluded) as $t) {
            $alias = \Cake\Utility\Inflector::camelize($t);
            $modelsOptions[$alias] = \Cake\Utility\Inflector::humanize($t);
        }
        $companies = $this->Permissions->Companies->find('list', limit: 200)->all();
        $roles = $this->fetchTable('Permissions')->Roles->find('list', limit: 200)->all();
        $this->set(compact('permission', 'modelsOptions', 'companies','roles'));
    }
        
     

    /**
     * Edit method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permission = $this->fetchTable('Permissions')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permission = $this->fetchTable('Permissions')->patchEntity($permission, $this->request->getData());
            if ($this->fetchTable('Permissions')->save($permission)) {
                $this->Flash->success(__('The permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permission could not be saved. Please, try again.'));
        }
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $tables = $conn->getSchemaCollection()->listTables();
        $excluded = ['phinxlog', 'sessions', 'audit_logs'];
        
        $modelsOptions = [];
        foreach (array_diff($tables, $excluded) as $t) {
            $alias = \Cake\Utility\Inflector::camelize($t);
            $modelsOptions[$alias] = \Cake\Utility\Inflector::humanize($t);
        }
        $companies = $this->Permissions->Companies->find('list', limit: 200)->all();
        $roles = $this->fetchTable('Permissions')->Roles->find('list', limit: 200)->all();
        $this->set(compact('permission', 'modelsOptions', 'companies','roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permission = $this->fetchTable('Permissions')->get($id);
        if ($this->fetchTable('Permissions')->delete($permission)) {
            $this->Flash->success(__('The permission has been deleted.'));
        } else {
            $this->Flash->error(__('The permission could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
