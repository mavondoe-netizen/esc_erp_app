<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanSchedules Controller
 *
 * @property \App\Model\Table\LoanSchedulesTable $LoanSchedules
 */
class LoanSchedulesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanSchedules->find()
            ->contain(['Loans']);
        $loanSchedules = $this->paginate($query);

        $this->set(compact('loanSchedules'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Schedule id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanSchedule = $this->LoanSchedules->get($id, contain: ['Loans']);
        $this->set(compact('loanSchedule'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanSchedule = $this->LoanSchedules->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanSchedule = $this->LoanSchedules->patchEntity($loanSchedule, $this->request->getData());
            if ($this->LoanSchedules->save($loanSchedule)) {
                $this->Flash->success(__('The loan schedule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan schedule could not be saved. Please, try again.'));
        }
        $loans = $this->LoanSchedules->Loans->find('list', limit: 200)->all();
        $this->set(compact('loanSchedule', 'loans'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Schedule id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanSchedule = $this->LoanSchedules->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanSchedule = $this->LoanSchedules->patchEntity($loanSchedule, $this->request->getData());
            if ($this->LoanSchedules->save($loanSchedule)) {
                $this->Flash->success(__('The loan schedule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan schedule could not be saved. Please, try again.'));
        }
        $loans = $this->LoanSchedules->Loans->find('list', limit: 200)->all();
        $this->set(compact('loanSchedule', 'loans'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Schedule id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanSchedule = $this->LoanSchedules->get($id);
        if ($this->LoanSchedules->delete($loanSchedule)) {
            $this->Flash->success(__('The loan schedule has been deleted.'));
        } else {
            $this->Flash->error(__('The loan schedule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
