<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TenderBids Controller
 *
 * @property \App\Model\Table\TenderBidsTable $TenderBids
 */
class TenderBidsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->TenderBids->find()
            ->contain(['Tenders', 'Suppliers', 'Companies']);
        $tenderBids = $this->paginate($query);

        $this->set(compact('tenderBids'));
    }

    /**
     * View method
     *
     * @param string|null $id Tender Bid id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tenderBid = $this->TenderBids->get($id, contain: ['Tenders', 'Suppliers', 'Companies']);
        $this->set(compact('tenderBid'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tenderBid = $this->TenderBids->newEmptyEntity();
        if ($this->request->is('post')) {
            $tenderBid = $this->TenderBids->patchEntity($tenderBid, $this->request->getData());
            if ($this->TenderBids->save($tenderBid)) {
                $this->Flash->success(__('The tender bid has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tender bid could not be saved. Please, try again.'));
        }
        $tenders = $this->TenderBids->Tenders->find('list', limit: 200)->all();
        $suppliers = $this->TenderBids->Suppliers->find('list', limit: 200)->all();
        $companies = $this->TenderBids->Companies->find('list', limit: 200)->all();
        $this->set(compact('tenderBid', 'tenders', 'suppliers', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tender Bid id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tenderBid = $this->TenderBids->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tenderBid = $this->TenderBids->patchEntity($tenderBid, $this->request->getData());
            if ($this->TenderBids->save($tenderBid)) {
                $this->Flash->success(__('The tender bid has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tender bid could not be saved. Please, try again.'));
        }
        $tenders = $this->TenderBids->Tenders->find('list', limit: 200)->all();
        $suppliers = $this->TenderBids->Suppliers->find('list', limit: 200)->all();
        $companies = $this->TenderBids->Companies->find('list', limit: 200)->all();
        $this->set(compact('tenderBid', 'tenders', 'suppliers', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tender Bid id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tenderBid = $this->TenderBids->get($id);
        if ($this->TenderBids->delete($tenderBid)) {
            $this->Flash->success(__('The tender bid has been deleted.'));
        } else {
            $this->Flash->error(__('The tender bid could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
