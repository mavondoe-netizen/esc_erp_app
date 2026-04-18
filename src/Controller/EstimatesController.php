<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Estimates Controller
 *
 * @property \App\Model\Table\EstimatesTable $Estimates
 */
class EstimatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Estimates->find()
            ->contain(['Companies', 'Customers']);
        $estimates = $this->paginate($query);

        $this->set(compact('estimates'));
    }

    /**
     * View method
     *
     * @param string|null $id Estimate id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estimate = $this->Estimates->get($id, contain: ['Companies', 'Customers', 'EstimateItems']);
        $this->set(compact('estimate'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estimate = $this->Estimates->newEmptyEntity();
        if ($this->request->is('post')) {
            $estimate = $this->Estimates->patchEntity($estimate, $this->request->getData(), [
                'associated' => ['EstimateItems']
            ]);
            if ($this->Estimates->save($estimate)) {
                $this->Flash->success(__('The estimate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estimate could not be saved. Please, try again.'));
        }
        $customers = $this->Estimates->Customers->find('list', limit: 200)->all();
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
                'hs_code' => $prod->hs_code,
                'vat_type' => $prod->vat_type,
            ];
        }
        
        $this->set(compact('estimate', 'customers', 'accounts', 'productsOptions', 'productsJson'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estimate id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estimate = $this->Estimates->get($id, contain: ['EstimateItems']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estimate = $this->Estimates->patchEntity($estimate, $this->request->getData(), [
                'associated' => ['EstimateItems']
            ]);
            if ($this->Estimates->save($estimate)) {
                $this->Flash->success(__('The estimate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estimate could not be saved. Please, try again.'));
        }
        $customers = $this->Estimates->Customers->find('list', limit: 200)->all();
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
                'hs_code' => $prod->hs_code,
                'vat_type' => $prod->vat_type,
            ];
        }
        
        $this->set(compact('estimate', 'customers', 'accounts', 'productsOptions', 'productsJson'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estimate id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estimate = $this->Estimates->get($id);
        if ($this->Estimates->delete($estimate)) {
            $this->Flash->success(__('The estimate has been deleted.'));
        } else {
            $this->Flash->error(__('The estimate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
