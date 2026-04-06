<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LeaveBalances Controller
 *
 * @property \App\Model\Table\LeaveBalancesTable $LeaveBalances
 */
class LeaveBalancesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LeaveBalances->find()
            ->contain(['Employees', 'LeaveTypes']);
        $leaveBalances = $this->paginate($query);

        $this->set(compact('leaveBalances'));
    }

    /**
     * View method
     *
     * @param string|null $id Leave Balance id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leaveBalance = $this->LeaveBalances->get($id, contain: ['Employees', 'LeaveTypes']);
        $this->set(compact('leaveBalance'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leaveBalance = $this->LeaveBalances->newEmptyEntity();
        if ($this->request->is('post')) {
            $leaveBalance = $this->LeaveBalances->patchEntity($leaveBalance, $this->request->getData());
            if ($this->LeaveBalances->save($leaveBalance)) {
                $this->Flash->success(__('The leave balance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave balance could not be saved. Please, try again.'));
        }
        $employees = $this->LeaveBalances->Employees->find('list', limit: 200)->all();
        $leaveTypes = $this->LeaveBalances->LeaveTypes->find('list', limit: 200)->all();
        $this->set(compact('leaveBalance', 'employees', 'leaveTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Leave Balance id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leaveBalance = $this->LeaveBalances->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leaveBalance = $this->LeaveBalances->patchEntity($leaveBalance, $this->request->getData());
            if ($this->LeaveBalances->save($leaveBalance)) {
                $this->Flash->success(__('The leave balance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leave balance could not be saved. Please, try again.'));
        }
        $employees = $this->LeaveBalances->Employees->find('list', limit: 200)->all();
        $leaveTypes = $this->LeaveBalances->LeaveTypes->find('list', limit: 200)->all();
        $this->set(compact('leaveBalance', 'employees', 'leaveTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Leave Balance id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leaveBalance = $this->LeaveBalances->get($id);
        if ($this->LeaveBalances->delete($leaveBalance)) {
            $this->Flash->success(__('The leave balance has been deleted.'));
        } else {
            $this->Flash->error(__('The leave balance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
