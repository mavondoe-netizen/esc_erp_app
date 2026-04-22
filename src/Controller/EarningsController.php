<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Earnings Controller
 *
 * @property \App\Model\Table\EarningsTable $Earnings
 */
class EarningsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Earnings->find()
            ->contain(['Accounts']);
        $earnings = $this->paginate($query);

        $this->set(compact('earnings'));
    }

    /**
     * View method
     *
     * @param string|null $id Earning id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $earning = $this->Earnings->get($id, contain: ['Accounts']);
        $this->set(compact('earning'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $earning = $this->Earnings->newEmptyEntity();
        if ($this->request->is('post')) {
            $earning = $this->Earnings->patchEntity($earning, $this->request->getData());
            if ($this->Earnings->save($earning)) {
                $this->Flash->success(__('The earning has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The earning could not be saved. Please, try again.'));
        }
        $accounts = $this->Earnings->Accounts->find('list', limit: 200)->all();
        $calculationTypes = [
            'Fixed Amount' => 'Fixed Amount',
            'Percentage of Basic' => 'Percentage of Basic Salary',
        ];
        $zimraOptions = [
            'Salary' => 'Basic Salary',
            'Bonus' => 'Bonus',
            'Allowance' => 'Allowances',
            'Benefit' => 'Benefits',
            'Commission' => 'Commissions',
            'Arrears' => 'Arrears',
        ];
        $this->set(compact('earning', 'accounts', 'calculationTypes', 'zimraOptions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Earning id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $earning = $this->Earnings->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $earning = $this->Earnings->patchEntity($earning, $this->request->getData());
            if ($this->Earnings->save($earning)) {
                $this->Flash->success(__('The earning has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The earning could not be saved. Please, try again.'));
        }
        $accounts = $this->Earnings->Accounts->find('list', limit: 200)->all();
        $calculationTypes = [
            'Fixed Amount' => 'Fixed Amount',
            'Percentage of Basic' => 'Percentage of Basic Salary',
        ];
        $zimraOptions = [
            'Salary' => 'Basic Salary',
            'Bonus' => 'Bonus',
            'Allowance' => 'Allowances',
            'Benefit' => 'Benefits',
            'Commission' => 'Commissions',
            'Arrears' => 'Arrears',
        ];
        $this->set(compact('earning', 'accounts', 'calculationTypes', 'zimraOptions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Earning id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $earning = $this->Earnings->get($id);
        if ($this->Earnings->delete($earning)) {
            $this->Flash->success(__('The earning has been deleted.'));
        } else {
            $this->Flash->error(__('The earning could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
