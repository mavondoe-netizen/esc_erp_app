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
     * Common list of world currencies for the dropdown.
     */
    private function getCurrencyOptions(): array
    {
        return [
            'USD' => 'USD – US Dollar',
            'ZWG' => 'ZWG – Zimbabwe Gold',
            'ZAR' => 'ZAR – South African Rand',
            'GBP' => 'GBP – British Pound',
            'EUR' => 'EUR – Euro',
            'BWP' => 'BWP – Botswana Pula',
            'MZN' => 'MZN – Mozambican Metical',
            'ZMW' => 'ZMW – Zambian Kwacha',
            'KES' => 'KES – Kenyan Shilling',
            'TZS' => 'TZS – Tanzanian Shilling',
            'UGX' => 'UGX – Ugandan Shilling',
            'NAD' => 'NAD – Namibian Dollar',
            'MWK' => 'MWK – Malawian Kwacha',
            'AED' => 'AED – UAE Dirham',
            'CNY' => 'CNY – Chinese Yuan',
            'JPY' => 'JPY – Japanese Yen',
            'AUD' => 'AUD – Australian Dollar',
            'CAD' => 'CAD – Canadian Dollar',
            'CHF' => 'CHF – Swiss Franc',
            'INR' => 'INR – Indian Rupee',
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ExchangeRates->find()
            ->contain(['Companies'])
            ->order(['date' => 'DESC', 'currency' => 'ASC']);
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

        // Pre-fill company_id from the authenticated tenant context
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');
        $exchangeRate->company_id = $companyId;

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Always enforce tenant company — don't allow cross-tenant posting
            $data['company_id'] = $companyId;

            $exchangeRate = $this->ExchangeRates->patchEntity($exchangeRate, $data);
            if ($this->ExchangeRates->save($exchangeRate)) {
                $this->Flash->success(__('The exchange rate has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exchange rate could not be saved. Please, try again.'));
        }

        $currencyOptions = $this->getCurrencyOptions();

        // Fetch the company name so the template can display it
        $company = null;
        if ($companyId) {
            try {
                $company = $this->fetchTable('Companies')->get($companyId);
            } catch (\Exception $e) { }
        }

        $this->set(compact('exchangeRate', 'currencyOptions', 'company'));
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
        $exchangeRate = $this->ExchangeRates->get($id, contain: ['Companies']);
        $companyId = \Cake\Core\Configure::read('Tenant.company_id');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // Always enforce tenant company on save
            $data['company_id'] = $companyId;

            $exchangeRate = $this->ExchangeRates->patchEntity($exchangeRate, $data);
            if ($this->ExchangeRates->save($exchangeRate)) {
                $this->Flash->success(__('The exchange rate has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exchange rate could not be saved. Please, try again.'));
        }

        $currencyOptions = $this->getCurrencyOptions();

        $company = null;
        if ($companyId) {
            try {
                $company = $this->fetchTable('Companies')->get($companyId);
            } catch (\Exception $e) { }
        }

        $this->set(compact('exchangeRate', 'currencyOptions', 'company'));
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
