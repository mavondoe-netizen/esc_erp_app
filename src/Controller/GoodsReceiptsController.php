<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * GoodsReceipts Controller
 *
 * @property \App\Model\Table\GoodsReceiptsTable $GoodsReceipts
 */
class GoodsReceiptsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->GoodsReceipts->find()
            ->contain(['Contracts', 'Users', 'Companies']);
        $goodsReceipts = $this->paginate($query);

        $this->set(compact('goodsReceipts'));
    }

    /**
     * View method
     *
     * @param string|null $id Goods Receipt id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $goodsReceipt = $this->GoodsReceipts->get($id, contain: ['Contracts', 'Users', 'Companies', 'GoodsReceiptItems']);
        $this->set(compact('goodsReceipt'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $goodsReceipt = $this->GoodsReceipts->newEmptyEntity();
        if ($this->request->is('post')) {
            $goodsReceipt = $this->GoodsReceipts->patchEntity($goodsReceipt, $this->request->getData());
            if ($this->GoodsReceipts->save($goodsReceipt)) {
                $this->Flash->success(__('The goods receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The goods receipt could not be saved. Please, try again.'));
        }
        $contracts = $this->GoodsReceipts->Contracts->find('list', limit: 200)->all();
        $users = $this->GoodsReceipts->Users->find('list', limit: 200)->all();
        $companies = $this->GoodsReceipts->Companies->find('list', limit: 200)->all();
        $this->set(compact('goodsReceipt', 'contracts', 'users', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Goods Receipt id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $goodsReceipt = $this->GoodsReceipts->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $goodsReceipt = $this->GoodsReceipts->patchEntity($goodsReceipt, $this->request->getData());
            if ($this->GoodsReceipts->save($goodsReceipt)) {
                $this->Flash->success(__('The goods receipt has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The goods receipt could not be saved. Please, try again.'));
        }
        $contracts = $this->GoodsReceipts->Contracts->find('list', limit: 200)->all();
        $users = $this->GoodsReceipts->Users->find('list', limit: 200)->all();
        $companies = $this->GoodsReceipts->Companies->find('list', limit: 200)->all();
        $this->set(compact('goodsReceipt', 'contracts', 'users', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Goods Receipt id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $goodsReceipt = $this->GoodsReceipts->get($id);
        if ($this->GoodsReceipts->delete($goodsReceipt)) {
            $this->Flash->success(__('The goods receipt has been deleted.'));
        } else {
            $this->Flash->error(__('The goods receipt could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
