<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanDeductions Controller
 *
 * @property \App\Model\Table\LoanDeductionsTable $LoanDeductions
 */
class LoanDeductionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanDeductions->find()
            ->contain(['Loans', 'Employees']);
        $loanDeductions = $this->paginate($query);

        $this->set(compact('loanDeductions'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Deduction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanDeduction = $this->LoanDeductions->get($id, contain: ['Loans', 'Employees']);
        $this->set(compact('loanDeduction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanDeduction = $this->LoanDeductions->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanDeduction = $this->LoanDeductions->patchEntity($loanDeduction, $this->request->getData());
            if ($this->LoanDeductions->save($loanDeduction)) {
                $this->Flash->success(__('The loan deduction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan deduction could not be saved. Please, try again.'));
        }
        $loans = $this->LoanDeductions->Loans->find('list', limit: 200)->all();
        $employees = $this->LoanDeductions->Employees->find('list', limit: 200)->all();
        $this->set(compact('loanDeduction', 'loans', 'employees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Deduction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanDeduction = $this->LoanDeductions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanDeduction = $this->LoanDeductions->patchEntity($loanDeduction, $this->request->getData());
            if ($this->LoanDeductions->save($loanDeduction)) {
                $this->Flash->success(__('The loan deduction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan deduction could not be saved. Please, try again.'));
        }
        $loans = $this->LoanDeductions->Loans->find('list', limit: 200)->all();
        $employees = $this->LoanDeductions->Employees->find('list', limit: 200)->all();
        $this->set(compact('loanDeduction', 'loans', 'employees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Deduction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanDeduction = $this->LoanDeductions->get($id);
        if ($this->LoanDeductions->delete($loanDeduction)) {
            $this->Flash->success(__('The loan deduction has been deleted.'));
        } else {
            $this->Flash->error(__('The loan deduction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
