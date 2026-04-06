<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ExchangeRates Controller
 *
 * @property \App\Model\Table\ExchangeRatesTable $ExchangeRates
 */
class ExchangeRatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ExchangeRates->find()
            ->contain(['Companies']);
        $exchangeRates = $this->paginate($query);

        $this->set(compact('exchangeRates'));
    }

    /**
     * View method
     *
     * @param string|null $id Exchange Rate id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exchangeRate = $this->ExchangeRates->get($id, contain: ['Companies']);
        $this->set(compact('exchangeRate'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $exchangeRate = $this->ExchangeRates->newEmptyEntity();
        if ($this->request->is('post')) {
            $exchangeRate = $this->ExchangeRates->patchEntity($exchangeRate, $this->request->getData());
            if ($this->ExchangeRates->save($exchangeRate)) {
                $this->Flash->success(__('The exchange rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exchange rate could not be saved. Please, try again.'));
        }
        $companies = $this->ExchangeRates->Companies->find('list', limit: 200)->all();
        $this->set(compact('exchangeRate', 'companies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exchange Rate id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $exchangeRate = $this->ExchangeRates->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exchangeRate = $this->ExchangeRates->patchEntity($exchangeRate, $this->request->getData());
            if ($this->ExchangeRates->save($exchangeRate)) {
                $this->Flash->success(__('The exchange rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exchange rate could not be saved. Please, try again.'));
        }
        $companies = $this->ExchangeRates->Companies->find('list', limit: 200)->all();
        $this->set(compact('exchangeRate', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exchange Rate id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exchangeRate = $this->ExchangeRates->get($id);
        if ($this->ExchangeRates->delete($exchangeRate)) {
            $this->Flash->success(__('The exchange rate has been deleted.'));
        } else {
            $this->Flash->error(__('The exchange rate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
