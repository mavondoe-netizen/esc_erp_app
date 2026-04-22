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
     */
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');
        $query = $this->ExchangeRates->find()
            ->where(['ExchangeRates.company_id' => $companyId])
            ->contain(['Companies']);
        $exchangeRates = $this->paginate($query);

        $this->set(compact('exchangeRates'));
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $companyId = $this->request->getAttribute('company_id');
        $exchangeRate = $this->ExchangeRates->get($id, [
            'contain' => ['Companies'],
            'conditions' => ['ExchangeRates.company_id' => $companyId]
        ]);
        $this->set(compact('exchangeRate'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');
        $exchangeRate = $this->ExchangeRates->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['company_id'] = $companyId;
            $exchangeRate = $this->ExchangeRates->patchEntity($exchangeRate, $data);
            if ($this->ExchangeRates->save($exchangeRate)) {
                $this->Flash->success(__('The exchange rate has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exchange rate could not be saved. Please, try again.'));
        }

        $company = $this->ExchangeRates->Companies->get($companyId);
        $currencyOptions = $this->_getCurrencyOptions();
        
        $this->set(compact('exchangeRate', 'company', 'currencyOptions'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $companyId = $this->request->getAttribute('company_id');
        $exchangeRate = $this->ExchangeRates->get($id, [
            'conditions' => ['ExchangeRates.company_id' => $companyId]
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['company_id'] = $companyId;
            $exchangeRate = $this->ExchangeRates->patchEntity($exchangeRate, $data);
            if ($this->ExchangeRates->save($exchangeRate)) {
                $this->Flash->success(__('The exchange rate has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exchange rate could not be saved. Please, try again.'));
        }

        $company = $this->ExchangeRates->Companies->get($companyId);
        $currencyOptions = $this->_getCurrencyOptions();
        
        $this->set(compact('exchangeRate', 'company', 'currencyOptions'));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyId = $this->request->getAttribute('company_id');
        $exchangeRate = $this->ExchangeRates->get($id, [
            'conditions' => ['ExchangeRates.company_id' => $companyId]
        ]);
        
        if ($this->ExchangeRates->delete($exchangeRate)) {
            $this->Flash->success(__('The exchange rate has been deleted.'));
        } else {
            $this->Flash->error(__('The exchange rate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Helper to get currency options
     */
    protected function _getCurrencyOptions(): array
    {
        return [
            'USD' => 'USD - US Dollar',
            'ZWG' => 'ZWG - Zimbabwe Gold',
            'ZAR' => 'ZAR - South African Rand',
            'GBP' => 'GBP - British Pound',
            'EUR' => 'EUR - Euro',
        ];
    }
}
