<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PayrollRuns Controller
 *
 */
class PayrollRunsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PayrollRuns->find();
        $payrollRuns = $this->paginate($query);

        $this->set(compact('payrollRuns'));
    }

    /**
     * View method
     *
     * @param string|null $id Payroll Run id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payrollRun = $this->PayrollRuns->get($id, contain: []);
        $this->set(compact('payrollRun'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payrollRun = $this->PayrollRuns->newEmptyEntity();
        if ($this->request->is('post')) {
            $payrollRun = $this->PayrollRuns->patchEntity($payrollRun, $this->request->getData());
            if ($this->PayrollRuns->save($payrollRun)) {
                $this->Flash->success(__('The payroll run has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll run could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollRun'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payroll Run id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payrollRun = $this->PayrollRuns->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payrollRun = $this->PayrollRuns->patchEntity($payrollRun, $this->request->getData());
            if ($this->PayrollRuns->save($payrollRun)) {
                $this->Flash->success(__('The payroll run has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll run could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollRun'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payroll Run id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payrollRun = $this->PayrollRuns->get($id);
        if ($this->PayrollRuns->delete($payrollRun)) {
            $this->Flash->success(__('The payroll run has been deleted.'));
        } else {
            $this->Flash->error(__('The payroll run could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
