<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Audits Controller
 *
 * @property \App\Model\Table\AuditsTable $Audits
 */
class AuditsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Audits->find()
            ->contain(['Companies', 'AuditPlans']);
        $audits = $this->paginate($query);

        $this->set(compact('audits'));
    }

    /**
     * View method
     *
     * @param string|null $id Audit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $audit = $this->Audits->get($id, contain: ['Companies', 'AuditPlans', 'AuditFindings']);
        $this->set(compact('audit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $audit = $this->Audits->newEmptyEntity();
        if ($this->request->is('post')) {
            $audit = $this->Audits->patchEntity($audit, $this->request->getData());
            if ($this->Audits->save($audit)) {
                $this->Flash->success(__('The audit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit could not be saved. Please, try again.'));
        }
        $companies = $this->Audits->Companies->find('list', limit: 200)->all();
        $auditPlans = $this->Audits->AuditPlans->find('list', limit: 200)->all();
        $this->set(compact('audit', 'companies', 'auditPlans'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Audit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $audit = $this->Audits->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $audit = $this->Audits->patchEntity($audit, $this->request->getData());
            if ($this->Audits->save($audit)) {
                $this->Flash->success(__('The audit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit could not be saved. Please, try again.'));
        }
        $companies = $this->Audits->Companies->find('list', limit: 200)->all();
        $auditPlans = $this->Audits->AuditPlans->find('list', limit: 200)->all();
        $this->set(compact('audit', 'companies', 'auditPlans'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Audit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $audit = $this->Audits->get($id);
        if ($this->Audits->delete($audit)) {
            $this->Flash->success(__('The audit has been deleted.'));
        } else {
            $this->Flash->error(__('The audit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
