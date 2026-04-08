<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanGuarantors Controller
 *
 * @property \App\Model\Table\LoanGuarantorsTable $LoanGuarantors
 */
class LoanGuarantorsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanGuarantors->find()
            ->contain(['LoanApplications']);
        $loanGuarantors = $this->paginate($query);

        $this->set(compact('loanGuarantors'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Guarantor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanGuarantor = $this->LoanGuarantors->get($id, contain: ['LoanApplications']);
        $this->set(compact('loanGuarantor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanGuarantor = $this->LoanGuarantors->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanGuarantor = $this->LoanGuarantors->patchEntity($loanGuarantor, $this->request->getData());
            if ($this->LoanGuarantors->save($loanGuarantor)) {
                $this->Flash->success(__('The loan guarantor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan guarantor could not be saved. Please, try again.'));
        }
        $loanApplications = $this->LoanGuarantors->LoanApplications->find('list', limit: 200)->all();
        $this->set(compact('loanGuarantor', 'loanApplications'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Guarantor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanGuarantor = $this->LoanGuarantors->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanGuarantor = $this->LoanGuarantors->patchEntity($loanGuarantor, $this->request->getData());
            if ($this->LoanGuarantors->save($loanGuarantor)) {
                $this->Flash->success(__('The loan guarantor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan guarantor could not be saved. Please, try again.'));
        }
        $loanApplications = $this->LoanGuarantors->LoanApplications->find('list', limit: 200)->all();
        $this->set(compact('loanGuarantor', 'loanApplications'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Guarantor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanGuarantor = $this->LoanGuarantors->get($id);
        if ($this->LoanGuarantors->delete($loanGuarantor)) {
            $this->Flash->success(__('The loan guarantor has been deleted.'));
        } else {
            $this->Flash->error(__('The loan guarantor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
