<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AuditFindings Controller
 *
 * @property \App\Model\Table\AuditFindingsTable $AuditFindings
 */
class AuditFindingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AuditFindings->find()
            ->contain(['Companies', 'Audits']);
        $auditFindings = $this->paginate($query);

        $this->set(compact('auditFindings'));
    }

    /**
     * View method
     *
     * @param string|null $id Audit Finding id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $auditFinding = $this->AuditFindings->get($id, contain: ['Companies', 'Audits']);
        $this->set(compact('auditFinding'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auditFinding = $this->AuditFindings->newEmptyEntity();
        if ($this->request->is('post')) {
            $auditFinding = $this->AuditFindings->patchEntity($auditFinding, $this->request->getData());
            if ($this->AuditFindings->save($auditFinding)) {
                $this->Flash->success(__('The audit finding has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit finding could not be saved. Please, try again.'));
        }
        $companies = $this->AuditFindings->Companies->find('list', limit: 200)->all();
        $audits = $this->AuditFindings->Audits->find('list', limit: 200)->all();
        $this->set(compact('auditFinding', 'companies', 'audits'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Audit Finding id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $auditFinding = $this->AuditFindings->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auditFinding = $this->AuditFindings->patchEntity($auditFinding, $this->request->getData());
            if ($this->AuditFindings->save($auditFinding)) {
                $this->Flash->success(__('The audit finding has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit finding could not be saved. Please, try again.'));
        }
        $companies = $this->AuditFindings->Companies->find('list', limit: 200)->all();
        $audits = $this->AuditFindings->Audits->find('list', limit: 200)->all();
        $this->set(compact('auditFinding', 'companies', 'audits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Audit Finding id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $auditFinding = $this->AuditFindings->get($id);
        if ($this->AuditFindings->delete($auditFinding)) {
            $this->Flash->success(__('The audit finding has been deleted.'));
        } else {
            $this->Flash->error(__('The audit finding could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
