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
        $query = $this->Modules->find()
            ->contain(['Companies']);
        $modules = $this->paginate($query);

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
        $module = $this->Modules->get($id, contain: ['Companies']);
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
        $companies = $this->Modules->Companies->find('list', limit: 200)->all();
        $modelsOptions = $this->_getModelsOptions();
        $this->set(compact('module', 'companies', 'modelsOptions'));
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
        $companies = $this->Modules->Companies->find('list', limit: 200)->all();
        $modelsOptions = $this->_getModelsOptions();
        $this->set(compact('module', 'companies', 'modelsOptions'));
    }

    /**
     * Build a list of available application Table model names for the dropdown.
     *
     * @return array<string, string>
     */
    private function _getModelsOptions(): array
    {
        $tableDir = APP . 'Model' . DS . 'Table' . DS;
        $options = [];
        if (is_dir($tableDir)) {
            foreach (glob($tableDir . '*Table.php') as $file) {
                $className = basename($file, '.php');       // e.g. "CustomersTable"
                $modelName = str_replace('Table', '', $className); // e.g. "Customers"
                if ($modelName !== '') {
                    $options[$modelName] = $modelName;
                }
            }
        }
        ksort($options);

        return $options;
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
}
