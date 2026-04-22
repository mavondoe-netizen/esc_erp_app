<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Loans Controller
 *
 * @property \App\Model\Table\LoansTable $Loans
 */
class LoansController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Loans->find()
            ->contain(['Companies', 'LoanClients', 'LoanApplications', 'LoanProducts']);
        $loans = $this->paginate($query);

        $this->set(compact('loans'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loan = $this->Loans->get($id, contain: ['Companies', 'LoanClients', 'LoanApplications', 'LoanProducts', 'DelinquencyFlags', 'LoanDeductions', 'LoanDisbursements', 'LoanRepayments', 'LoanRestructures', 'LoanSchedules', 'LoanWriteoffs']);
        $this->set(compact('loan'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loan = $this->Loans->newEmptyEntity();
        if ($this->request->is('post')) {
            $loan = $this->Loans->patchEntity($loan, $this->request->getData());
            if ($this->Loans->save($loan)) {
                $this->Flash->success(__('The loan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan could not be saved. Please, try again.'));
        }
        $companies = $this->Loans->Companies->find('list', limit: 200)->all();
        $loanClients = $this->Loans->LoanClients->find('list', limit: 200)->all();
        $loanApplications = $this->Loans->LoanApplications->find('list', limit: 200)->all();
        $loanProducts = $this->Loans->LoanProducts->find('list', limit: 200)->all();
        $this->set(compact('loan', 'companies', 'loanClients', 'loanApplications', 'loanProducts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loan = $this->Loans->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loan = $this->Loans->patchEntity($loan, $this->request->getData());
            if ($this->Loans->save($loan)) {
                $this->Flash->success(__('The loan has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan could not be saved. Please, try again.'));
        }
        $companies = $this->Loans->Companies->find('list', limit: 200)->all();
        $loanClients = $this->Loans->LoanClients->find('list', limit: 200)->all();
        $loanApplications = $this->Loans->LoanApplications->find('list', limit: 200)->all();
        $loanProducts = $this->Loans->LoanProducts->find('list', limit: 200)->all();
        $this->set(compact('loan', 'companies', 'loanClients', 'loanApplications', 'loanProducts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loan = $this->Loans->get($id);
        if ($this->Loans->delete($loan)) {
            $this->Flash->success(__('The loan has been deleted.'));
        } else {
            $this->Flash->error(__('The loan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
