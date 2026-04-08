<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * RiskAssessments Controller
 *
 * @property \App\Model\Table\RiskAssessmentsTable $RiskAssessments
 */
class RiskAssessmentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->RiskAssessments->find()
            ->contain(['Companies', 'Risks']);
        $riskAssessments = $this->paginate($query);

        $this->set(compact('riskAssessments'));
    }

    /**
     * View method
     *
     * @param string|null $id Risk Assessment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $riskAssessment = $this->RiskAssessments->get($id, contain: ['Companies', 'Risks']);
        $this->set(compact('riskAssessment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $riskAssessment = $this->RiskAssessments->newEmptyEntity();
        if ($this->request->is('post')) {
            $riskAssessment = $this->RiskAssessments->patchEntity($riskAssessment, $this->request->getData());
            if ($this->RiskAssessments->save($riskAssessment)) {
                $this->Flash->success(__('The risk assessment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The risk assessment could not be saved. Please, try again.'));
        }
        $companies = $this->RiskAssessments->Companies->find('list', limit: 200)->all();
        $risks = $this->RiskAssessments->Risks->find('list', limit: 200)->all();
        $this->set(compact('riskAssessment', 'companies', 'risks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Risk Assessment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $riskAssessment = $this->RiskAssessments->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $riskAssessment = $this->RiskAssessments->patchEntity($riskAssessment, $this->request->getData());
            if ($this->RiskAssessments->save($riskAssessment)) {
                $this->Flash->success(__('The risk assessment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The risk assessment could not be saved. Please, try again.'));
        }
        $companies = $this->RiskAssessments->Companies->find('list', limit: 200)->all();
        $risks = $this->RiskAssessments->Risks->find('list', limit: 200)->all();
        $this->set(compact('riskAssessment', 'companies', 'risks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Risk Assessment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $riskAssessment = $this->RiskAssessments->get($id);
        if ($this->RiskAssessments->delete($riskAssessment)) {
            $this->Flash->success(__('The risk assessment has been deleted.'));
        } else {
            $this->Flash->error(__('The risk assessment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
