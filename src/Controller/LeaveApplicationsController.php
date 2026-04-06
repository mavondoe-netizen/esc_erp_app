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

    /**
     * Approve method
     *
     * @param string|null $id Leave Application id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function approve($id = null)
    {
        $this->request->allowMethod(['post']);
        $application = $this->LeaveApplications->get($id, contain: []);
        
        if ($application->status === 'Approved') {
            $this->Flash->error(__('This application is already approved.'));
            return $this->redirect(['action' => 'index']);
        }

        // Get the relevant balance for this year
        $year = (int)$application->start_date->format('Y');
        
        // Load the Balance table
        $balancesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('LeaveBalances');
        $balance = $balancesTable->find()
            ->where([
                'employee_id' => $application->employee_id,
                'leave_type_id' => $application->leave_type_id,
                'year' => $year
            ])->first();

        if (!$balance) {
            $this->Flash->error(__('No leave balance initialized for this employee and year. Please set up a balance first.'));
            return $this->redirect(['action' => 'index']);
        }

        if (($balance->days_entitled - $balance->days_taken) < $application->days_requested) {
            $this->Flash->error(__('Not enough days remaining in the balance to approve this application.'));
            return $this->redirect(['action' => 'index']);
        }

        // Update Balance
        $balance->days_taken += $application->days_requested;
        
        // Update Application Status
        $application->status = 'Approved';

        if ($this->LeaveApplications->save($application) && $balancesTable->save($balance)) {
            $this->Flash->success(__('The leave application has been approved and balance updated.'));
        } else {
            $this->Flash->error(__('The leave application could not be approved. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
