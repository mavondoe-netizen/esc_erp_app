<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanWriteoffs Controller
 *
 * @property \App\Model\Table\LoanWriteoffsTable $LoanWriteoffs
 */
class LoanWriteoffsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanWriteoffs->find()
            ->contain(['Loans', 'Accounts']);
        $loanWriteoffs = $this->paginate($query);

        $this->set(compact('loanWriteoffs'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Writeoff id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanWriteoff = $this->LoanWriteoffs->get($id, contain: ['Loans', 'Accounts']);
        $this->set(compact('loanWriteoff'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanWriteoff = $this->LoanWriteoffs->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanWriteoff = $this->LoanWriteoffs->patchEntity($loanWriteoff, $this->request->getData());
            if ($this->LoanWriteoffs->save($loanWriteoff)) {
                $this->Flash->success(__('The loan writeoff has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan writeoff could not be saved. Please, try again.'));
        }
        $loans = $this->LoanWriteoffs->Loans->find('list', limit: 200)->all();
        $accounts = $this->LoanWriteoffs->Accounts->find('list', limit: 200)->all();
        $this->set(compact('loanWriteoff', 'loans', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Writeoff id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanWriteoff = $this->LoanWriteoffs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanWriteoff = $this->LoanWriteoffs->patchEntity($loanWriteoff, $this->request->getData());
            if ($this->LoanWriteoffs->save($loanWriteoff)) {
                $this->Flash->success(__('The loan writeoff has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan writeoff could not be saved. Please, try again.'));
        }
        $loans = $this->LoanWriteoffs->Loans->find('list', limit: 200)->all();
        $accounts = $this->LoanWriteoffs->Accounts->find('list', limit: 200)->all();
        $this->set(compact('loanWriteoff', 'loans', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Writeoff id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanWriteoff = $this->LoanWriteoffs->get($id);
        if ($this->LoanWriteoffs->delete($loanWriteoff)) {
            $this->Flash->success(__('The loan writeoff has been deleted.'));
        } else {
            $this->Flash->error(__('The loan writeoff could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
