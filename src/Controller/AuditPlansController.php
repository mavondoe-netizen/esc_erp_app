<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AuditPlans Controller
 *
 * @property \App\Model\Table\AuditPlansTable $AuditPlans
 */
class AuditPlansController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AuditPlans->find()
            ->contain(['Companies']);
        $auditPlans = $this->paginate($query);

        $this->set(compact('auditPlans'));
    }

    /**
     * View method
     *
     * @param string|null $id Audit Plan id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $auditPlan = $this->AuditPlans->get($id, contain: ['Companies', 'Audits']);
        $this->set(compact('auditPlan'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auditPlan = $this->AuditPlans->newEmptyEntity();
        if ($this->request->is('post')) {
            $auditPlan = $this->AuditPlans->patchEntity($auditPlan, $this->request->getData());
            if ($this->AuditPlans->save($auditPlan)) {
                $this->Flash->success(__('The audit plan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit plan could not be saved. Please, try again.'));
        }
        $companies = $this->AuditPlans->Companies->find('list', limit: 200)->all();
        $this->set(compact('auditPlan', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Audit Plan id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $auditPlan = $this->AuditPlans->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auditPlan = $this->AuditPlans->patchEntity($auditPlan, $this->request->getData());
            if ($this->AuditPlans->save($auditPlan)) {
                $this->Flash->success(__('The audit plan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit plan could not be saved. Please, try again.'));
        }
        $companies = $this->AuditPlans->Companies->find('list', limit: 200)->all();
        $this->set(compact('auditPlan', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Audit Plan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $auditPlan = $this->AuditPlans->get($id);
        if ($this->AuditPlans->delete($auditPlan)) {
            $this->Flash->success(__('The audit plan has been deleted.'));
        } else {
            $this->Flash->error(__('The audit plan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
