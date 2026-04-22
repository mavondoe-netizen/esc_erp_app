<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AccountsInvoices Controller
 *
 */
class AccountsInvoicesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AccountsInvoices->find();
        $accountsInvoices = $this->paginate($query);

        $this->set(compact('accountsInvoices'));
    }

    /**
     * View method
     *
     * @param string|null $id Accounts Invoice id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $accountsInvoice = $this->AccountsInvoices->get($id, contain: []);
        $this->set(compact('accountsInvoice'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $accountsInvoice = $this->AccountsInvoices->newEmptyEntity();
        if ($this->request->is('post')) {
            $accountsInvoice = $this->AccountsInvoices->patchEntity($accountsInvoice, $this->request->getData());
            if ($this->AccountsInvoices->save($accountsInvoice)) {
                $this->Flash->success(__('The accounts invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accounts invoice could not be saved. Please, try again.'));
        }
        $this->set(compact('accountsInvoice'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Accounts Invoice id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $accountsInvoice = $this->AccountsInvoices->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $accountsInvoice = $this->AccountsInvoices->patchEntity($accountsInvoice, $this->request->getData());
            if ($this->AccountsInvoices->save($accountsInvoice)) {
                $this->Flash->success(__('The accounts invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The accounts invoice could not be saved. Please, try again.'));
        }
        $this->set(compact('accountsInvoice'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Accounts Invoice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $accountsInvoice = $this->AccountsInvoices->get($id);
        if ($this->AccountsInvoices->delete($accountsInvoice)) {
            $this->Flash->success(__('The accounts invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The accounts invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
