<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LeaveApplications Controller
 *
 * @property \App\Model\Table\LeaveApplicationsTable $LeaveApplications
 */
class LeaveApplicationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LeaveApplications->find()
            ->contain(['Employees', 'LeaveTypes']);
        $leaveApplications = $this->paginate($query);

        $this->set(compact('leaveApplications'));
    }

    /**
     * View method
     *
     * @param string|null $id Leave Application id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leaveApplication = $this->LeaveApplications->get($id, contain: ['Employees', 'LeaveTypes']);
        $this->set(compact('leaveApplication'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leaveApplication = $this->LeaveApplications->newEmptyEntity();
        if ($this->request->is('post')) {
            $leaveApplication = $this->LeaveApplications->patchEntity($leaveApplication, $this->request->getData());
            if ($this->LeaveApplications->save($leaveApplication)) {
                $this->Flash->success(__('The leave application has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave application could not be saved. Please, try again.'));
        }
        $employees = $this->LeaveApplications->Employees->find('list', limit: 200)->all();
        $leaveTypes = $this->LeaveApplications->LeaveTypes->find('list', limit: 200)->all();
        $this->set(compact('leaveApplication', 'employees', 'leaveTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Leave Application id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leaveApplication = $this->LeaveApplications->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leaveApplication = $this->LeaveApplications->patchEntity($leaveApplication, $this->request->getData());
            if ($this->LeaveApplications->save($leaveApplication)) {
                $this->Flash->success(__('The leave application has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave application could not be saved. Please, try again.'));
        }
        $employees = $this->LeaveApplications->Employees->find('list', limit: 200)->all();
        $leaveTypes = $this->LeaveApplications->LeaveTypes->find('list', limit: 200)->all();
        $this->set(compact('leaveApplication', 'employees', 'leaveTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Leave Application id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leaveApplication = $this->LeaveApplications->get($id);
        if ($this->LeaveApplications->delete($leaveApplication)) {
            $this->Flash->success(__('The leave application has been deleted.'));
        } else {
            $this->Flash->error(__('The leave application could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
