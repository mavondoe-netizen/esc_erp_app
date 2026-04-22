<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ReceiptsTransactions Controller
 *
 */
class ReceiptsTransactionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ReceiptsTransactions->find();
        $receiptsTransactions = $this->paginate($query);

        $this->set(compact('receiptsTransactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Receipts Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $receiptsTransaction = $this->ReceiptsTransactions->get($id, contain: []);
        $this->set(compact('receiptsTransaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $receiptsTransaction = $this->ReceiptsTransactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $receiptsTransaction = $this->ReceiptsTransactions->patchEntity($receiptsTransaction, $this->request->getData());
            if ($this->ReceiptsTransactions->save($receiptsTransaction)) {
                $this->Flash->success(__('The receipts transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The receipts transaction could not be saved. Please, try again.'));
        }
        $this->set(compact('receiptsTransaction'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Receipts Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $receiptsTransaction = $this->ReceiptsTransactions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $receiptsTransaction = $this->ReceiptsTransactions->patchEntity($receiptsTransaction, $this->request->getData());
            if ($this->ReceiptsTransactions->save($receiptsTransaction)) {
                $this->Flash->success(__('The receipts transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The receipts transaction could not be saved. Please, try again.'));
        }
        $this->set(compact('receiptsTransaction'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Receipts Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $receiptsTransaction = $this->ReceiptsTransactions->get($id);
        if ($this->ReceiptsTransactions->delete($receiptsTransaction)) {
            $this->Flash->success(__('The receipts transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The receipts transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
