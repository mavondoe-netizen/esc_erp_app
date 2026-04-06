<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 */
class EmployeesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Employees')->find();
        $employees = $this->paginate($query);

        $this->set(compact('employees'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employee = $this->fetchTable('Employees')->get($id, contain: ['Payslips']);
        $this->set(compact('employee'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employee = $this->fetchTable('Employees')->newEmptyEntity();
        if ($this->request->is('post')) {
            $employee = $this->fetchTable('Employees')->patchEntity($employee, $this->request->getData());
            if ($this->fetchTable('Employees')->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $companies = $this->fetchTable('Employees')->Companies->find('list', limit: 200)->all();
        $this->set(compact('employee', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employee = $this->fetchTable('Employees')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee = $this->fetchTable('Employees')->patchEntity($employee, $this->request->getData());
            if ($this->fetchTable('Employees')->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
       $companies = $this->fetchTable('Employees')->Companies->find('list', limit: 200)->all();
        $this->set(compact('employee', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employee = $this->fetchTable('Employees')->get($id);
        if ($this->fetchTable('Employees')->delete($employee)) {
            $this->Flash->success(__('The employee has been deleted.'));
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
