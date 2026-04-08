<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanClients Controller
 *
 * @property \App\Model\Table\LoanClientsTable $LoanClients
 */
class LoanClientsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanClients->find()
            ->contain(['Companies', 'Employees']);
        $loanClients = $this->paginate($query);

        $this->set(compact('loanClients'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Client id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanClient = $this->LoanClients->get($id, contain: ['Companies', 'Employees']);
        $this->set(compact('loanClient'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanClient = $this->LoanClients->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanClient = $this->LoanClients->patchEntity($loanClient, $this->request->getData());
            if ($this->LoanClients->save($loanClient)) {
                $this->Flash->success(__('The loan client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan client could not be saved. Please, try again.'));
        }
        $companies = $this->LoanClients->Companies->find('list', limit: 200)->all();
        $employees = $this->LoanClients->Employees->find('list', limit: 200)->all();
        $this->set(compact('loanClient', 'companies', 'employees'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Client id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanClient = $this->LoanClients->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanClient = $this->LoanClients->patchEntity($loanClient, $this->request->getData());
            if ($this->LoanClients->save($loanClient)) {
                $this->Flash->success(__('The loan client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan client could not be saved. Please, try again.'));
        }
        $companies = $this->LoanClients->Companies->find('list', limit: 200)->all();
        $employees = $this->LoanClients->Employees->find('list', limit: 200)->all();
        $this->set(compact('loanClient', 'companies', 'employees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Client id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanClient = $this->LoanClients->get($id);
        if ($this->LoanClients->delete($loanClient)) {
            $this->Flash->success(__('The loan client has been deleted.'));
        } else {
            $this->Flash->error(__('The loan client could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
