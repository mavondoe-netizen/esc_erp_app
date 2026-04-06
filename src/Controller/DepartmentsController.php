<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Departments Controller
 *
 * @property \App\Model\Table\DepartmentsTable $Departments
 */
class DepartmentsController extends AppController
{
    /**
     * Index method
     */
    public function index()
    {
        $departments = $this->Departments->find()->all();
        $this->set(compact('departments'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $department = $this->Departments->newEmptyEntity();
        if ($this->request->is('post')) {
            $department = $this->Departments->patchEntity($department, $this->request->getData());
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
        }
        $this->set(compact('department'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $department = $this->Departments->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $department = $this->Departments->patchEntity($department, $this->request->getData());
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
        }
        $this->set(compact('department'));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $department = $this->Departments->get($id);
        if ($this->Departments->delete($department)) {
            $this->Flash->success(__('The department has been deleted.'));
        } else {
            $this->Flash->error(__('The department could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
