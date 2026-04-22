<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LeasePayments Controller
 *
 * @property \App\Model\Table\LeasePaymentsTable $LeasePayments
 */
class LeasePaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LeasePayments->find()
            ->contain(['Companies', 'Enrolments', 'Tenants', 'Units', 'Buildings', 'Accounts']);
        $leasePayments = $this->paginate($query);

        $this->set(compact('leasePayments'));
    }

    /**
     * View method
     *
     * @param string|null $id Lease Payment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leasePayment = $this->LeasePayments->get($id, contain: ['Companies', 'Enrolments', 'Tenants', 'Units', 'Buildings', 'Accounts']);
        $this->set(compact('leasePayment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $leasePayment = $this->LeasePayments->newEmptyEntity();
        if ($this->request->is('post')) {
            $leasePayment = $this->LeasePayments->patchEntity($leasePayment, $this->request->getData());
            if ($this->LeasePayments->save($leasePayment)) {
                $this->Flash->success(__('The lease payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lease payment could not be saved. Please, try again.'));
        }
        $companies = $this->LeasePayments->Companies->find('list', limit: 200)->all();
        $enrolments = $this->LeasePayments->Enrolments->find('list', limit: 200)->all();
        $tenants = $this->LeasePayments->Tenants->find('list', limit: 200)->all();
        $units = $this->LeasePayments->Units->find('list', limit: 200)->all();
        $buildings = $this->LeasePayments->Buildings->find('list', limit: 200)->all();
        $accounts = $this->LeasePayments->Accounts->find('list', limit: 200)->all();
        $this->set(compact('leasePayment', 'companies', 'enrolments', 'tenants', 'units', 'buildings', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lease Payment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $leasePayment = $this->LeasePayments->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leasePayment = $this->LeasePayments->patchEntity($leasePayment, $this->request->getData());
            if ($this->LeasePayments->save($leasePayment)) {
                $this->Flash->success(__('The lease payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lease payment could not be saved. Please, try again.'));
        }
        $companies = $this->LeasePayments->Companies->find('list', limit: 200)->all();
        $enrolments = $this->LeasePayments->Enrolments->find('list', limit: 200)->all();
        $tenants = $this->LeasePayments->Tenants->find('list', limit: 200)->all();
        $units = $this->LeasePayments->Units->find('list', limit: 200)->all();
        $buildings = $this->LeasePayments->Buildings->find('list', limit: 200)->all();
        $accounts = $this->LeasePayments->Accounts->find('list', limit: 200)->all();
        $this->set(compact('leasePayment', 'companies', 'enrolments', 'tenants', 'units', 'buildings', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lease Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leasePayment = $this->LeasePayments->get($id);
        if ($this->LeasePayments->delete($leasePayment)) {
            $this->Flash->success(__('The lease payment has been deleted.'));
        } else {
            $this->Flash->error(__('The lease payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
