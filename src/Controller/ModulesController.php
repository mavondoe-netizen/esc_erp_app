<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Modules Controller
 *
 * @property \App\Model\Table\ModulesTable $Modules
 */
class ModulesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */


    public function index()
    {
        $query = $this->Modules->find();
        
        // Pass settings array dynamically into the paginate trait
        $modules = $this->paginate($query, [
            'sortableFields' => [
                'id', 'name', 'model', 'is_active', 'created', 'modified'
            ]
        ]);

        $this->set(compact('modules'));
    }

    /**
     * View method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $module = $this->Modules->get($id, contain: []);
        $this->set(compact('module'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $module = $this->Modules->newEmptyEntity();
        if ($this->request->is('post')) {
            $module = $this->Modules->patchEntity($module, $this->request->getData());
            if ($this->Modules->save($module)) {
                $this->Flash->success(__('The module has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The module could not be saved. Please, try again.'));
        }
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $tables = $conn->getSchemaCollection()->listTables();
        $excluded = ['phinxlog', 'sessions', 'audit_logs'];
        
        $modelsOptions = [];
        foreach (array_diff($tables, $excluded) as $t) {
            $alias = \Cake\Utility\Inflector::camelize($t);
            $modelsOptions[$alias] = \Cake\Utility\Inflector::humanize($t);
        }
        $companies = $this->Modules->Companies->find('list', limit: 200)->all();
        $this->set(compact('module', 'modelsOptions', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $module = $this->Modules->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $module = $this->Modules->patchEntity($module, $this->request->getData());
            if ($this->Modules->save($module)) {
                $this->Flash->success(__('The module has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The module could not be saved. Please, try again.'));
        }
        $conn = \Cake\Datasource\ConnectionManager::get('default');
        $tables = $conn->getSchemaCollection()->listTables();
        $excluded = ['phinxlog', 'sessions', 'audit_logs'];
        
        $modelsOptions = [];
        foreach (array_diff($tables, $excluded) as $t) {
            $alias = \Cake\Utility\Inflector::camelize($t);
            $modelsOptions[$alias] = \Cake\Utility\Inflector::humanize($t);
        }
        $companies = $this->Modules->Companies->find('list', limit: 200)->all();
        $this->set(compact('module', 'modelsOptions', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $module = $this->Modules->get($id);
        if ($this->Modules->delete($module)) {
            $this->Flash->success(__('The module has been deleted.'));
        } else {
            $this->Flash->error(__('The module could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Toggle method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|null Redirects back.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function toggle($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $module = $this->Modules->get($id);
        $module->is_active = !$module->is_active;
        if ($this->Modules->save($module)) {
            $status = $module->is_active ? 'activated' : 'deactivated';
            $this->Flash->success(__("The module {0} has been {1}.", $module->name, $status));
        } else {
            $this->Flash->error(__('The module status could not be changed. Please, try again.'));
        }

        return $this->redirect($this->referer(['controller' => 'Dashboard', 'action' => 'index']));
    }
}
