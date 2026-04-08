<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanRepayments Controller
 *
 * @property \App\Model\Table\LoanRepaymentsTable $LoanRepayments
 */
class LoanRepaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanRepayments->find()
            ->contain(['Loans', 'Accounts']);
        $loanRepayments = $this->paginate($query);

        $this->set(compact('loanRepayments'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Repayment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanRepayment = $this->LoanRepayments->get($id, contain: ['Loans', 'Accounts']);
        $this->set(compact('loanRepayment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanRepayment = $this->LoanRepayments->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanRepayment = $this->LoanRepayments->patchEntity($loanRepayment, $this->request->getData());
            if ($this->LoanRepayments->save($loanRepayment)) {
                $this->Flash->success(__('The loan repayment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan repayment could not be saved. Please, try again.'));
        }
        $loans = $this->LoanRepayments->Loans->find('list', limit: 200)->all();
        $accounts = $this->LoanRepayments->Accounts->find('list', limit: 200)->all();
        $this->set(compact('loanRepayment', 'loans', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Repayment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanRepayment = $this->LoanRepayments->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanRepayment = $this->LoanRepayments->patchEntity($loanRepayment, $this->request->getData());
            if ($this->LoanRepayments->save($loanRepayment)) {
                $this->Flash->success(__('The loan repayment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan repayment could not be saved. Please, try again.'));
        }
        $loans = $this->LoanRepayments->Loans->find('list', limit: 200)->all();
        $accounts = $this->LoanRepayments->Accounts->find('list', limit: 200)->all();
        $this->set(compact('loanRepayment', 'loans', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Repayment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanRepayment = $this->LoanRepayments->get($id);
        if ($this->LoanRepayments->delete($loanRepayment)) {
            $this->Flash->success(__('The loan repayment has been deleted.'));
        } else {
            $this->Flash->error(__('The loan repayment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
