<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanDisbursements Controller
 *
 * @property \App\Model\Table\LoanDisbursementsTable $LoanDisbursements
 */
class LoanDisbursementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanDisbursements->find()
            ->contain(['Loans', 'Accounts']);
        $loanDisbursements = $this->paginate($query);

        $this->set(compact('loanDisbursements'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Disbursement id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanDisbursement = $this->LoanDisbursements->get($id, contain: ['Loans', 'Accounts']);
        $this->set(compact('loanDisbursement'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanDisbursement = $this->LoanDisbursements->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanDisbursement = $this->LoanDisbursements->patchEntity($loanDisbursement, $this->request->getData());
            if ($this->LoanDisbursements->save($loanDisbursement)) {
                $this->Flash->success(__('The loan disbursement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan disbursement could not be saved. Please, try again.'));
        }
        $loans = $this->LoanDisbursements->Loans->find('list', limit: 200)->all();
        $accounts = $this->LoanDisbursements->Accounts->find('list', limit: 200)->all();
        $this->set(compact('loanDisbursement', 'loans', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Disbursement id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanDisbursement = $this->LoanDisbursements->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanDisbursement = $this->LoanDisbursements->patchEntity($loanDisbursement, $this->request->getData());
            if ($this->LoanDisbursements->save($loanDisbursement)) {
                $this->Flash->success(__('The loan disbursement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan disbursement could not be saved. Please, try again.'));
        }
        $loans = $this->LoanDisbursements->Loans->find('list', limit: 200)->all();
        $accounts = $this->LoanDisbursements->Accounts->find('list', limit: 200)->all();
        $this->set(compact('loanDisbursement', 'loans', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Disbursement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanDisbursement = $this->LoanDisbursements->get($id);
        if ($this->LoanDisbursements->delete($loanDisbursement)) {
            $this->Flash->success(__('The loan disbursement has been deleted.'));
        } else {
            $this->Flash->error(__('The loan disbursement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
