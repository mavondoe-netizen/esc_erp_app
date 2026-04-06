<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DebitNoteItems Controller
 *
 * @property \App\Model\Table\DebitNoteItemsTable $DebitNoteItems
 */
class DebitNoteItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->DebitNoteItems->find()
            ->contain(['DebitNotes', 'Products', 'Accounts']);
        $debitNoteItems = $this->paginate($query);

        $this->set(compact('debitNoteItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Debit Note Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $debitNoteItem = $this->DebitNoteItems->get($id, contain: ['DebitNotes', 'Products', 'Accounts']);
        $this->set(compact('debitNoteItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $debitNoteItem = $this->DebitNoteItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $debitNoteItem = $this->DebitNoteItems->patchEntity($debitNoteItem, $this->request->getData());
            if ($this->DebitNoteItems->save($debitNoteItem)) {
                $this->Flash->success(__('The debit note item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The debit note item could not be saved. Please, try again.'));
        }
        $debitNotes = $this->DebitNoteItems->DebitNotes->find('list', limit: 200)->all();
        $products = $this->DebitNoteItems->Products->find('list', limit: 200)->all();
        $accounts = $this->DebitNoteItems->Accounts->find('list', limit: 200)->all();
        $this->set(compact('debitNoteItem', 'debitNotes', 'products', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Debit Note Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $debitNoteItem = $this->DebitNoteItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $debitNoteItem = $this->DebitNoteItems->patchEntity($debitNoteItem, $this->request->getData());
            if ($this->DebitNoteItems->save($debitNoteItem)) {
                $this->Flash->success(__('The debit note item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The debit note item could not be saved. Please, try again.'));
        }
        $debitNotes = $this->DebitNoteItems->DebitNotes->find('list', limit: 200)->all();
        $products = $this->DebitNoteItems->Products->find('list', limit: 200)->all();
        $accounts = $this->DebitNoteItems->Accounts->find('list', limit: 200)->all();
        $this->set(compact('debitNoteItem', 'debitNotes', 'products', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Debit Note Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $debitNoteItem = $this->DebitNoteItems->get($id);
        if ($this->DebitNoteItems->delete($debitNoteItem)) {
            $this->Flash->success(__('The debit note item has been deleted.'));
        } else {
            $this->Flash->error(__('The debit note item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
