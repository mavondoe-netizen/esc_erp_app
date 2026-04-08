<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanRestructures Controller
 *
 * @property \App\Model\Table\LoanRestructuresTable $LoanRestructures
 */
class LoanRestructuresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanRestructures->find()
            ->contain(['Loans']);
        $loanRestructures = $this->paginate($query);

        $this->set(compact('loanRestructures'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Restructure id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanRestructure = $this->LoanRestructures->get($id, contain: ['Loans']);
        $this->set(compact('loanRestructure'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanRestructure = $this->LoanRestructures->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanRestructure = $this->LoanRestructures->patchEntity($loanRestructure, $this->request->getData());
            if ($this->LoanRestructures->save($loanRestructure)) {
                $this->Flash->success(__('The loan restructure has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan restructure could not be saved. Please, try again.'));
        }
        $loans = $this->LoanRestructures->Loans->find('list', limit: 200)->all();
        $this->set(compact('loanRestructure', 'loans'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Restructure id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanRestructure = $this->LoanRestructures->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanRestructure = $this->LoanRestructures->patchEntity($loanRestructure, $this->request->getData());
            if ($this->LoanRestructures->save($loanRestructure)) {
                $this->Flash->success(__('The loan restructure has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan restructure could not be saved. Please, try again.'));
        }
        $loans = $this->LoanRestructures->Loans->find('list', limit: 200)->all();
        $this->set(compact('loanRestructure', 'loans'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Restructure id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanRestructure = $this->LoanRestructures->get($id);
        if ($this->LoanRestructures->delete($loanRestructure)) {
            $this->Flash->success(__('The loan restructure has been deleted.'));
        } else {
            $this->Flash->error(__('The loan restructure could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
