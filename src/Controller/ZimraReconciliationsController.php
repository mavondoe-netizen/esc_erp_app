<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ZimraReconciliations Controller
 *
 * @property \App\Model\Table\ZimraReconciliationsTable $ZimraReconciliations
 */
class ZimraReconciliationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ZimraReconciliations->find()
            ->contain(['Companies', 'Employees', 'PayPeriods']);
        $zimraReconciliations = $this->paginate($query);

        $this->set(compact('zimraReconciliations'));
    }

    /**
     * View method
     *
     * @param string|null $id Zimra Reconciliation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $zimraReconciliation = $this->ZimraReconciliations->get($id, contain: ['Companies', 'Employees', 'PayPeriods']);
        $this->set(compact('zimraReconciliation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $zimraReconciliation = $this->ZimraReconciliations->newEmptyEntity();
        if ($this->request->is('post')) {
            $zimraReconciliation = $this->ZimraReconciliations->patchEntity($zimraReconciliation, $this->request->getData());
            if ($this->ZimraReconciliations->save($zimraReconciliation)) {
                $this->Flash->success(__('The zimra reconciliation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The zimra reconciliation could not be saved. Please, try again.'));
        }
        $companies = $this->ZimraReconciliations->Companies->find('list', limit: 200)->all();
        $employees = $this->ZimraReconciliations->Employees->find('list', limit: 200)->all();
        $payPeriods = $this->ZimraReconciliations->PayPeriods->find('list', limit: 200)->all();
        $this->set(compact('zimraReconciliation', 'companies', 'employees', 'payPeriods'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Zimra Reconciliation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $zimraReconciliation = $this->ZimraReconciliations->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $zimraReconciliation = $this->ZimraReconciliations->patchEntity($zimraReconciliation, $this->request->getData());
            $zimraReconciliation->variance = $zimraReconciliation->assessed_tax_amount - $zimraReconciliation->payroll_tax_amount;
            if ($this->ZimraReconciliations->save($zimraReconciliation)) {
                $this->Flash->success(__('The zimra reconciliation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The zimra reconciliation could not be saved. Please, try again.'));
        }
        $companies = $this->ZimraReconciliations->Companies->find('list', limit: 200)->all();
        $employees = $this->ZimraReconciliations->Employees->find('list', limit: 200)->all();
        $payPeriods = $this->ZimraReconciliations->PayPeriods->find('list', limit: 200)->all();
        $this->set(compact('zimraReconciliation', 'companies', 'employees', 'payPeriods'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Zimra Reconciliation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $zimraReconciliation = $this->ZimraReconciliations->get($id);
        if ($this->ZimraReconciliations->delete($zimraReconciliation)) {
            $this->Flash->success(__('The zimra reconciliation has been deleted.'));
        } else {
            $this->Flash->error(__('The zimra reconciliation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Generate Monthly Reconciliations
     */
    public function generate()
    {
        $this->request->allowMethod(['post']);
        $payPeriodId = (int)$this->request->getData('pay_period_id');
        $zimraService = new \App\Service\Payroll\ZimraService();
        if ($zimraService->generateMonthlyReconciliation($payPeriodId)) {
            $this->Flash->success(__('Monthly reconciliations generated successfully.'));
        } else {
            $this->Flash->error(__('Could not generate reconciliations.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Clear Variance via Ledger Resolution
     */
    public function clear($id = null)
    {
        $zimraReconciliation = $this->ZimraReconciliations->get($id, contain: ['Employees', 'PayPeriods']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resolutionReference = $this->request->getData('cleared_via');
            $zimraService = new \App\Service\Payroll\ZimraService();
            if ($zimraService->clearVariance($zimraReconciliation->id, $resolutionReference)) {
                $this->Flash->success(__('Variance cleared successfully.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Could not clear variance or variance is 0.'));
            }
        }
        $this->set(compact('zimraReconciliation'));
    }
}

