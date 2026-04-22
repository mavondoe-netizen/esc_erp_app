<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanApplications Controller
 *
 * @property \App\Model\Table\LoanApplicationsTable $LoanApplications
 */
class LoanApplicationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanApplications->find()
            ->contain(['Companies', 'LoanProducts']);
        $loanApplications = $this->paginate($query);

        $this->set(compact('loanApplications'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Application id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanApplication = $this->LoanApplications->get($id, contain: ['Companies', 'LoanProducts', 'LoanGuarantors', 'Loans']);
        $this->set(compact('loanApplication'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanApplication = $this->LoanApplications->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanApplication = $this->LoanApplications->patchEntity($loanApplication, $this->request->getData());
            if ($this->LoanApplications->save($loanApplication)) {
                $this->Flash->success(__('The loan application has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan application could not be saved. Please, try again.'));
        }
        $companies = $this->LoanApplications->Companies->find('list', limit: 200)->all();
        $loanProducts = $this->LoanApplications->LoanProducts->find('list', limit: 200)->all();
        $this->set(compact('loanApplication', 'companies', 'loanProducts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Application id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanApplication = $this->LoanApplications->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanApplication = $this->LoanApplications->patchEntity($loanApplication, $this->request->getData());
            if ($this->LoanApplications->save($loanApplication)) {
                $this->Flash->success(__('The loan application has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan application could not be saved. Please, try again.'));
        }
        $companies = $this->LoanApplications->Companies->find('list', limit: 200)->all();
        $loanProducts = $this->LoanApplications->LoanProducts->find('list', limit: 200)->all();
        $this->set(compact('loanApplication', 'companies', 'loanProducts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Application id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanApplication = $this->LoanApplications->get($id);
        if ($this->LoanApplications->delete($loanApplication)) {
            $this->Flash->success(__('The loan application has been deleted.'));
        } else {
            $this->Flash->error(__('The loan application could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
