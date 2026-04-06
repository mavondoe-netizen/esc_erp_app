<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DebitNotes Controller
 *
 * @property \App\Model\Table\DebitNotesTable $DebitNotes
 */
class DebitNotesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->DebitNotes->find()
            ->contain(['Companies', 'Suppliers']);
        $debitNotes = $this->paginate($query);

        $this->set(compact('debitNotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Debit Note id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $debitNote = $this->DebitNotes->get($id, contain: ['Companies', 'Suppliers', 'DebitNoteItems']);
        $this->set(compact('debitNote'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $debitNote = $this->DebitNotes->newEmptyEntity();
        if ($this->request->is('post')) {
            $debitNote = $this->DebitNotes->patchEntity($debitNote, $this->request->getData(), [
                'associated' => ['DebitNoteItems']
            ]);
            if ($this->DebitNotes->save($debitNote)) {
                $this->Flash->success(__('The debit note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The debit note could not be saved. Please, try again.'));
        }
        $suppliers = $this->DebitNotes->Suppliers->find('list', limit: 200)->all();
        $accounts = $this->fetchTable('Accounts')->find('list', limit: 200)->all();
        
        $productsData = $this->fetchTable('Products')->find('all')->all();
        $productsOptions = [];
        $productsJson = [];
        foreach ($productsData as $prod) {
            $productsOptions[$prod->id] = $prod->name;
            $productsJson[$prod->id] = [
                'unit_price' => $prod->unit_price,
                'vat_rate' => $prod->vat_rate,
                'account_id' => $prod->account_id,
            ];
        }
        
        $this->set(compact('debitNote', 'suppliers', 'accounts', 'productsOptions', 'productsJson'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Debit Note id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $debitNote = $this->DebitNotes->get($id, contain: ['DebitNoteItems']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $debitNote = $this->DebitNotes->patchEntity($debitNote, $this->request->getData(), [
                'associated' => ['DebitNoteItems']
            ]);
            if ($this->DebitNotes->save($debitNote)) {
                $this->Flash->success(__('The debit note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The debit note could not be saved. Please, try again.'));
        }
        $suppliers = $this->DebitNotes->Suppliers->find('list', limit: 200)->all();
        $accounts = $this->fetchTable('Accounts')->find('list', limit: 200)->all();
        
        $productsData = $this->fetchTable('Products')->find('all')->all();
        $productsOptions = [];
        $productsJson = [];
        foreach ($productsData as $prod) {
            $productsOptions[$prod->id] = $prod->name;
            $productsJson[$prod->id] = [
                'unit_price' => $prod->unit_price,
                'vat_rate' => $prod->vat_rate,
                'account_id' => $prod->account_id,
            ];
        }
        
        $this->set(compact('debitNote', 'suppliers', 'accounts', 'productsOptions', 'productsJson'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Debit Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $debitNote = $this->DebitNotes->get($id);
        if ($this->DebitNotes->delete($debitNote)) {
            $this->Flash->success(__('The debit note has been deleted.'));
        } else {
            $this->Flash->error(__('The debit note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
