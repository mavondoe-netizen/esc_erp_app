<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ComplianceChecks Controller
 *
 * @property \App\Model\Table\ComplianceChecksTable $ComplianceChecks
 */
class ComplianceChecksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ComplianceChecks->find()
            ->contain(['Companies']);
        $complianceChecks = $this->paginate($query);

        $this->set(compact('complianceChecks'));
    }

    /**
     * View method
     *
     * @param string|null $id Compliance Check id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $complianceCheck = $this->ComplianceChecks->get($id, contain: ['Companies']);
        $this->set(compact('complianceCheck'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $complianceCheck = $this->ComplianceChecks->newEmptyEntity();
        if ($this->request->is('post')) {
            $complianceCheck = $this->ComplianceChecks->patchEntity($complianceCheck, $this->request->getData());
            if ($this->ComplianceChecks->save($complianceCheck)) {
                $this->Flash->success(__('The compliance check has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The compliance check could not be saved. Please, try again.'));
        }
        $companies = $this->ComplianceChecks->Companies->find('list', limit: 200)->all();
        $this->set(compact('complianceCheck', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Compliance Check id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $complianceCheck = $this->ComplianceChecks->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $complianceCheck = $this->ComplianceChecks->patchEntity($complianceCheck, $this->request->getData());
            if ($this->ComplianceChecks->save($complianceCheck)) {
                $this->Flash->success(__('The compliance check has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The compliance check could not be saved. Please, try again.'));
        }
        $companies = $this->ComplianceChecks->Companies->find('list', limit: 200)->all();
        $this->set(compact('complianceCheck', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Compliance Check id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $complianceCheck = $this->ComplianceChecks->get($id);
        if ($this->ComplianceChecks->delete($complianceCheck)) {
            $this->Flash->success(__('The compliance check has been deleted.'));
        } else {
            $this->Flash->error(__('The compliance check could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
