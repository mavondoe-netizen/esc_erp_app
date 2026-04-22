<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PayslipItems Controller
 *
 * @property \App\Model\Table\PayslipItemsTable $PayslipItems
 */
class PayslipItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PayslipItems->find()
            ->contain(['Payslips']);
        $payslipItems = $this->paginate($query);

        $this->set(compact('payslipItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Payslip Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payslipItem = $this->PayslipItems->get($id, contain: ['Payslips']);
        $this->set(compact('payslipItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payslipItem = $this->PayslipItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $payslipItem = $this->PayslipItems->patchEntity($payslipItem, $this->request->getData());
            if ($this->PayslipItems->save($payslipItem)) {
                $this->Flash->success(__('The payslip item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payslip item could not be saved. Please, try again.'));
        }
        $payslips = $this->PayslipItems->Payslips->find('list', limit: 200)->all();
        $this->set(compact('payslipItem', 'payslips'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payslip Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payslipItem = $this->PayslipItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payslipItem = $this->PayslipItems->patchEntity($payslipItem, $this->request->getData());
            if ($this->PayslipItems->save($payslipItem)) {
                $this->Flash->success(__('The payslip item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payslip item could not be saved. Please, try again.'));
        }
        $payslips = $this->PayslipItems->Payslips->find('list', limit: 200)->all();
        $this->set(compact('payslipItem', 'payslips'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payslip Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payslipItem = $this->PayslipItems->get($id);
        if ($this->PayslipItems->delete($payslipItem)) {
            $this->Flash->success(__('The payslip item has been deleted.'));
        } else {
            $this->Flash->error(__('The payslip item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
