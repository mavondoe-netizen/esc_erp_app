<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * InvoiceItems Controller
 *
 * @property \App\Model\Table\InvoiceItemsTable $InvoiceItems
 */
class InvoiceItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('InvoiceItems')->find()
            ->contain(['Invoices', 'Accounts']);
        $invoiceItems = $this->paginate($query);

        $this->set(compact('invoiceItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Invoice Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoiceItem = $this->fetchTable('InvoiceItems')->get($id, contain: ['Invoices', 'Accounts']);
        $this->set(compact('invoiceItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invoiceItem = $this->fetchTable('InvoiceItems')->newEmptyEntity();
        if ($this->request->is('post')) {
            $invoiceItem = $this->fetchTable('InvoiceItems')->patchEntity($invoiceItem, $this->request->getData());
            if ($this->fetchTable('InvoiceItems')->save($invoiceItem)) {
                $this->Flash->success(__('The invoice item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice item could not be saved. Please, try again.'));
        }
        $invoices = $this->fetchTable('InvoiceItems')->Invoices->find('list', limit: 200)->all();
        $accounts = $this->fetchTable('InvoiceItems')->Accounts->find('list', limit: 200)->all();
        
        $this->set(compact('invoiceItem', 'invoices', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoiceItem = $this->fetchTable('InvoiceItems')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoiceItem = $this->fetchTable('InvoiceItems')->patchEntity($invoiceItem, $this->request->getData());
            if ($this->fetchTable('InvoiceItems')->save($invoiceItem)) {
                $this->Flash->success(__('The invoice item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice item could not be saved. Please, try again.'));
        }
        $invoices = $this->fetchTable('InvoiceItems')->Invoices->find('list', limit: 200)->all();
        $accounts = $this->fetchTable('InvoiceItems')->Accounts->find('list', limit: 200)->all();
        $this->set(compact('invoiceItem', 'invoices', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoiceItem = $this->fetchTable('InvoiceItems')->get($id);
        if ($this->fetchTable('InvoiceItems')->delete($invoiceItem)) {
            $this->Flash->success(__('The invoice item has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
