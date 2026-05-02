<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Evaluations Controller
 *
 * @property \App\Model\Table\EvaluationsTable $Evaluations
 */
class EvaluationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Evaluations->find()
            ->contain(['Tenders', 'Users', 'Evaluators', 'Suppliers', 'Companies']);
        $evaluations = $this->paginate($query);

        $this->set(compact('evaluations'));
    }

    /**
     * View method
     *
     * @param string|null $id Evaluation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $evaluation = $this->Evaluations->get($id, contain: ['Tenders', 'Users', 'Evaluators', 'Suppliers', 'Companies']);
        $this->set(compact('evaluation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $evaluation = $this->Evaluations->newEmptyEntity();
        if ($this->request->is('post')) {
            $evaluation = $this->Evaluations->patchEntity($evaluation, $this->request->getData());
            if ($this->Evaluations->save($evaluation)) {
                $this->Flash->success(__('The evaluation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The evaluation could not be saved. Please, try again.'));
        }
        $tenders = $this->Evaluations->Tenders->find('list', limit: 200)->all();
        $users = $this->Evaluations->Users->find('list', limit: 200)->all();
        $evaluators = $this->Evaluations->Evaluators->find('list', limit: 200)->all();
        $suppliers = $this->Evaluations->Suppliers->find('list', limit: 200)->all();
        $companies = $this->Evaluations->Companies->find('list', limit: 200)->all();
        $this->set(compact('evaluation', 'tenders', 'users', 'evaluators', 'suppliers', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Evaluation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $evaluation = $this->Evaluations->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $evaluation = $this->Evaluations->patchEntity($evaluation, $this->request->getData());
            if ($this->Evaluations->save($evaluation)) {
                $this->Flash->success(__('The evaluation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The evaluation could not be saved. Please, try again.'));
        }
        $tenders = $this->Evaluations->Tenders->find('list', limit: 200)->all();
        $users = $this->Evaluations->Users->find('list', limit: 200)->all();
        $evaluators = $this->Evaluations->Evaluators->find('list', limit: 200)->all();
        $suppliers = $this->Evaluations->Suppliers->find('list', limit: 200)->all();
        $companies = $this->Evaluations->Companies->find('list', limit: 200)->all();
        $this->set(compact('evaluation', 'tenders', 'users', 'evaluators', 'suppliers', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Evaluation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $evaluation = $this->Evaluations->get($id);
        if ($this->Evaluations->delete($evaluation)) {
            $this->Flash->success(__('The evaluation has been deleted.'));
        } else {
            $this->Flash->error(__('The evaluation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
