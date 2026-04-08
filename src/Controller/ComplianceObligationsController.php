<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ComplianceObligations Controller
 *
 * @property \App\Model\Table\ComplianceObligationsTable $ComplianceObligations
 */
class ComplianceObligationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ComplianceObligations->find()
            ->contain(['Companies', 'Regulations']);
        $complianceObligations = $this->paginate($query);

        $this->set(compact('complianceObligations'));
    }

    /**
     * View method
     *
     * @param string|null $id Compliance Obligation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $complianceObligation = $this->ComplianceObligations->get($id, contain: ['Companies', 'Regulations']);
        $this->set(compact('complianceObligation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $complianceObligation = $this->ComplianceObligations->newEmptyEntity();
        if ($this->request->is('post')) {
            $complianceObligation = $this->ComplianceObligations->patchEntity($complianceObligation, $this->request->getData());
            if ($this->ComplianceObligations->save($complianceObligation)) {
                $this->Flash->success(__('The compliance obligation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The compliance obligation could not be saved. Please, try again.'));
        }
        $companies = $this->ComplianceObligations->Companies->find('list', limit: 200)->all();
        $regulations = $this->ComplianceObligations->Regulations->find('list', limit: 200)->all();
        $this->set(compact('complianceObligation', 'companies', 'regulations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Compliance Obligation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $complianceObligation = $this->ComplianceObligations->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $complianceObligation = $this->ComplianceObligations->patchEntity($complianceObligation, $this->request->getData());
            if ($this->ComplianceObligations->save($complianceObligation)) {
                $this->Flash->success(__('The compliance obligation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The compliance obligation could not be saved. Please, try again.'));
        }
        $companies = $this->ComplianceObligations->Companies->find('list', limit: 200)->all();
        $regulations = $this->ComplianceObligations->Regulations->find('list', limit: 200)->all();
        $this->set(compact('complianceObligation', 'companies', 'regulations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Compliance Obligation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $complianceObligation = $this->ComplianceObligations->get($id);
        if ($this->ComplianceObligations->delete($complianceObligation)) {
            $this->Flash->success(__('The compliance obligation has been deleted.'));
        } else {
            $this->Flash->error(__('The compliance obligation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
