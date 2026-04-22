<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SalaryStructures Controller
 *
 * @property \App\Model\Table\SalaryStructuresTable $SalaryStructures
 */
class SalaryStructuresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->SalaryStructures->find()
            ->contain(['Users', 'Roles']);
        $salaryStructures = $this->paginate($query);

        $this->set(compact('salaryStructures'));
    }

    /**
     * View method
     *
     * @param string|null $id Salary Structure id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $salaryStructure = $this->SalaryStructures->get($id, contain: ['Users', 'Roles', 'PayrollRecords']);
        $this->set(compact('salaryStructure'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $salaryStructure = $this->SalaryStructures->newEmptyEntity();
        if ($this->request->is('post')) {
            $salaryStructure = $this->SalaryStructures->patchEntity($salaryStructure, $this->request->getData());
            if ($this->SalaryStructures->save($salaryStructure)) {
                $this->Flash->success(__('The salary structure has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salary structure could not be saved. Please, try again.'));
        }
        $users = $this->SalaryStructures->Users->find('list', limit: 200)->all();
        $roles = $this->SalaryStructures->Roles->find('list', limit: 200)->all();
        $this->set(compact('salaryStructure', 'users', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Salary Structure id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $salaryStructure = $this->SalaryStructures->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $salaryStructure = $this->SalaryStructures->patchEntity($salaryStructure, $this->request->getData());
            if ($this->SalaryStructures->save($salaryStructure)) {
                $this->Flash->success(__('The salary structure has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salary structure could not be saved. Please, try again.'));
        }
        $users = $this->SalaryStructures->Users->find('list', limit: 200)->all();
        $roles = $this->SalaryStructures->Roles->find('list', limit: 200)->all();
        $this->set(compact('salaryStructure', 'users', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Salary Structure id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salaryStructure = $this->SalaryStructures->get($id);
        if ($this->SalaryStructures->delete($salaryStructure)) {
            $this->Flash->success(__('The salary structure has been deleted.'));
        } else {
            $this->Flash->error(__('The salary structure could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
