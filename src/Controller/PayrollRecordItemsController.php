<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PayrollRecordItems Controller
 *
 */
class PayrollRecordItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PayrollRecordItems->find();
        $payrollRecordItems = $this->paginate($query);

        $this->set(compact('payrollRecordItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Payroll Record Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payrollRecordItem = $this->PayrollRecordItems->get($id, contain: []);
        $this->set(compact('payrollRecordItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payrollRecordItem = $this->PayrollRecordItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $payrollRecordItem = $this->PayrollRecordItems->patchEntity($payrollRecordItem, $this->request->getData());
            if ($this->PayrollRecordItems->save($payrollRecordItem)) {
                $this->Flash->success(__('The payroll record item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll record item could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollRecordItem'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payroll Record Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payrollRecordItem = $this->PayrollRecordItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payrollRecordItem = $this->PayrollRecordItems->patchEntity($payrollRecordItem, $this->request->getData());
            if ($this->PayrollRecordItems->save($payrollRecordItem)) {
                $this->Flash->success(__('The payroll record item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll record item could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollRecordItem'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payroll Record Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payrollRecordItem = $this->PayrollRecordItems->get($id);
        if ($this->PayrollRecordItems->delete($payrollRecordItem)) {
            $this->Flash->success(__('The payroll record item has been deleted.'));
        } else {
            $this->Flash->error(__('The payroll record item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
