<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PayrollComponents Controller
 *
 */
class PayrollComponentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PayrollComponents->find();
        $payrollComponents = $this->paginate($query);

        $this->set(compact('payrollComponents'));
    }

    /**
     * View method
     *
     * @param string|null $id Payroll Component id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payrollComponent = $this->PayrollComponents->get($id, contain: []);
        $this->set(compact('payrollComponent'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payrollComponent = $this->PayrollComponents->newEmptyEntity();
        if ($this->request->is('post')) {
            $payrollComponent = $this->PayrollComponents->patchEntity($payrollComponent, $this->request->getData());
            if ($this->PayrollComponents->save($payrollComponent)) {
                $this->Flash->success(__('The payroll component has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll component could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollComponent'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payroll Component id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payrollComponent = $this->PayrollComponents->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payrollComponent = $this->PayrollComponents->patchEntity($payrollComponent, $this->request->getData());
            if ($this->PayrollComponents->save($payrollComponent)) {
                $this->Flash->success(__('The payroll component has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payroll component could not be saved. Please, try again.'));
        }
        $this->set(compact('payrollComponent'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payroll Component id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payrollComponent = $this->PayrollComponents->get($id);
        if ($this->PayrollComponents->delete($payrollComponent)) {
            $this->Flash->success(__('The payroll component has been deleted.'));
        } else {
            $this->Flash->error(__('The payroll component could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
