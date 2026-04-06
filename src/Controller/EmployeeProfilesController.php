<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * EmployeeProfiles Controller
 *
 * @property \App\Model\Table\EmployeeProfilesTable $EmployeeProfiles
 */
class EmployeeProfilesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('EmployeeProfiles')->find()
            ->contain(['Users']);
        $employeeProfiles = $this->paginate($query);

        $this->set(compact('employeeProfiles'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee Profile id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeeProfile = $this->fetchTable('EmployeeProfiles')->get($id, contain: ['Users']);
        $this->set(compact('employeeProfile'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeeProfile = $this->fetchTable('EmployeeProfiles')->newEmptyEntity();
        if ($this->request->is('post')) {
            $employeeProfile = $this->fetchTable('EmployeeProfiles')->patchEntity($employeeProfile, $this->request->getData());
            if ($this->fetchTable('EmployeeProfiles')->save($employeeProfile)) {
                $this->Flash->success(__('The employee profile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee profile could not be saved. Please, try again.'));
        }
        $users = $this->fetchTable('EmployeeProfiles')->Users->find('list', limit: 200)->all();
        $this->set(compact('employeeProfile', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Profile id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeeProfile = $this->fetchTable('EmployeeProfiles')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeProfile = $this->fetchTable('EmployeeProfiles')->patchEntity($employeeProfile, $this->request->getData());
            if ($this->fetchTable('EmployeeProfiles')->save($employeeProfile)) {
                $this->Flash->success(__('The employee profile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee profile could not be saved. Please, try again.'));
        }
        $users = $this->fetchTable('EmployeeProfiles')->Users->find('list', limit: 200)->all();
        $this->set(compact('employeeProfile', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Profile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeProfile = $this->fetchTable('EmployeeProfiles')->get($id);
        if ($this->fetchTable('EmployeeProfiles')->delete($employeeProfile)) {
            $this->Flash->success(__('The employee profile has been deleted.'));
        } else {
            $this->Flash->error(__('The employee profile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
