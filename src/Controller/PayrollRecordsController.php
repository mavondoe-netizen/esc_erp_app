<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PayrollRecords Controller
 *
 */
class PayrollRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PayrollRecords->find();
        $payrollRecords = $this->paginate($query);

        $this->set(compact('payrollRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Payroll Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payrollRecord = $this->PayrollRecords->get($id, contain: []);
        $this->set(compact('payrollRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payrollRecord = $this->PayrollRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $payrollRecord = $this->PayrollRecords->patchEntity($payrollRecord, $this->request->getData());
            if ($this->PayrollRecords->save($payrollRecord)) {
                $this->Flash->success(__('The payroll record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll record could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollRecord'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payroll Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payrollRecord = $this->PayrollRecords->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payrollRecord = $this->PayrollRecords->patchEntity($payrollRecord, $this->request->getData());
            if ($this->PayrollRecords->save($payrollRecord)) {
                $this->Flash->success(__('The payroll record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll record could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollRecord'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payroll Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payrollRecord = $this->PayrollRecords->get($id);
        if ($this->PayrollRecords->delete($payrollRecord)) {
            $this->Flash->success(__('The payroll record has been deleted.'));
        } else {
            $this->Flash->error(__('The payroll record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
