<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LoanProducts Controller
 *
 * @property \App\Model\Table\LoanProductsTable $LoanProducts
 */
class LoanProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->LoanProducts->find()
            ->contain(['Companies']);
        $loanProducts = $this->paginate($query);

        $this->set(compact('loanProducts'));
    }

    /**
     * View method
     *
     * @param string|null $id Loan Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loanProduct = $this->LoanProducts->get($id, contain: ['Companies', 'LoanApplications', 'Loans']);
        $this->set(compact('loanProduct'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loanProduct = $this->LoanProducts->newEmptyEntity();
        if ($this->request->is('post')) {
            $loanProduct = $this->LoanProducts->patchEntity($loanProduct, $this->request->getData());
            if ($this->LoanProducts->save($loanProduct)) {
                $this->Flash->success(__('The loan product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan product could not be saved. Please, try again.'));
        }
        $companies = $this->LoanProducts->Companies->find('list', limit: 200)->all();
        $this->set(compact('loanProduct', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Loan Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loanProduct = $this->LoanProducts->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loanProduct = $this->LoanProducts->patchEntity($loanProduct, $this->request->getData());
            if ($this->LoanProducts->save($loanProduct)) {
                $this->Flash->success(__('The loan product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan product could not be saved. Please, try again.'));
        }
        $companies = $this->LoanProducts->Companies->find('list', limit: 200)->all();
        $this->set(compact('loanProduct', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Loan Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loanProduct = $this->LoanProducts->get($id);
        if ($this->LoanProducts->delete($loanProduct)) {
            $this->Flash->success(__('The loan product has been deleted.'));
        } else {
            $this->Flash->error(__('The loan product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
