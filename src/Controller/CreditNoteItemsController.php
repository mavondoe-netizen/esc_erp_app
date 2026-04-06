<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CreditNoteItems Controller
 *
 * @property \App\Model\Table\CreditNoteItemsTable $CreditNoteItems
 */
class CreditNoteItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->CreditNoteItems->find()
            ->contain(['CreditNotes', 'Products', 'Accounts']);
        $creditNoteItems = $this->paginate($query);

        $this->set(compact('creditNoteItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Credit Note Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $creditNoteItem = $this->CreditNoteItems->get($id, contain: ['CreditNotes', 'Products', 'Accounts']);
        $this->set(compact('creditNoteItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $creditNoteItem = $this->CreditNoteItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $creditNoteItem = $this->CreditNoteItems->patchEntity($creditNoteItem, $this->request->getData());
            if ($this->CreditNoteItems->save($creditNoteItem)) {
                $this->Flash->success(__('The credit note item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The credit note item could not be saved. Please, try again.'));
        }
        $creditNotes = $this->CreditNoteItems->CreditNotes->find('list', limit: 200)->all();
        $products = $this->CreditNoteItems->Products->find('list', limit: 200)->all();
        $accounts = $this->CreditNoteItems->Accounts->find('list', limit: 200)->all();
        $this->set(compact('creditNoteItem', 'creditNotes', 'products', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Credit Note Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $creditNoteItem = $this->CreditNoteItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $creditNoteItem = $this->CreditNoteItems->patchEntity($creditNoteItem, $this->request->getData());
            if ($this->CreditNoteItems->save($creditNoteItem)) {
                $this->Flash->success(__('The credit note item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The credit note item could not be saved. Please, try again.'));
        }
        $creditNotes = $this->CreditNoteItems->CreditNotes->find('list', limit: 200)->all();
        $products = $this->CreditNoteItems->Products->find('list', limit: 200)->all();
        $accounts = $this->CreditNoteItems->Accounts->find('list', limit: 200)->all();
        $this->set(compact('creditNoteItem', 'creditNotes', 'products', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Credit Note Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $creditNoteItem = $this->CreditNoteItems->get($id);
        if ($this->CreditNoteItems->delete($creditNoteItem)) {
            $this->Flash->success(__('The credit note item has been deleted.'));
        } else {
            $this->Flash->error(__('The credit note item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
