<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * BankRules Controller
 *
 * @property \App\Model\Table\BankRulesTable $BankRules
 */
class BankRulesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BankRules->find()
            ->contain(['Accounts', 'Companies']);
        $bankRules = $this->paginate($query);

        $this->set(compact('bankRules'));
    }

    /**
     * View method
     *
     * @param string|null $id Bank Rule id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bankRule = $this->BankRules->get($id, contain: ['Accounts', 'Companies']);
        $this->set(compact('bankRule'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bankRule = $this->BankRules->newEmptyEntity();
        if ($this->request->is('post')) {
            $bankRule = $this->BankRules->patchEntity($bankRule, $this->request->getData());
            if ($this->BankRules->save($bankRule)) {
                $this->Flash->success(__('The bank rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bank rule could not be saved. Please, try again.'));
        }
        $accounts = $this->BankRules->Accounts->find('list', limit: 200)->all();
        $companies = $this->BankRules->Companies->find('list', limit: 200)->all();
        $this->set(compact('bankRule', 'accounts', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bank Rule id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bankRule = $this->BankRules->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bankRule = $this->BankRules->patchEntity($bankRule, $this->request->getData());
            if ($this->BankRules->save($bankRule)) {
                $this->Flash->success(__('The bank rule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bank rule could not be saved. Please, try again.'));
        }
        $accounts = $this->BankRules->Accounts->find('list', limit: 200)->all();
        $companies = $this->BankRules->Companies->find('list', limit: 200)->all();
        $this->set(compact('bankRule', 'accounts', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bank Rule id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bankRule = $this->BankRules->get($id);
        if ($this->BankRules->delete($bankRule)) {
            $this->Flash->success(__('The bank rule has been deleted.'));
        } else {
            $this->Flash->error(__('The bank rule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
