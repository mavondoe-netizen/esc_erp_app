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
        $query = $this->fetchTable('Earnings')->find()
            ->contain(['Accounts']);
        $earnings = $this->paginate($query);

        $zimraOptions = \App\Utility\ZimraMapping::getOptions();
        $this->set(compact('earnings', 'zimraOptions'));
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
        $earning = $this->fetchTable('Earnings')->get($id, contain: ['Accounts']);
        $this->set(compact('earning'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $earning = $this->fetchTable('Earnings')->newEmptyEntity();
        if ($this->request->is('post')) {
            $earning = $this->fetchTable('Earnings')->patchEntity($earning, $this->request->getData());
            if ($this->fetchTable('Earnings')->save($earning)) {
                $this->Flash->success(__('The earning has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The earning could not be saved. Please, try again.'));
        }
        $accounts = $this->fetchTable('Earnings')->Accounts->find('list', limit: 200)->all();
        $zimraOptions = \App\Utility\ZimraMapping::getOptions();
        $calculationTypes = [
            'Fixed Amount' => 'Fixed Amount',
            'Percentage of Basic Salary' => 'Percentage of Basic Salary',
            'Hourly/Daily Rate' => 'Hourly/Daily Rate (Units * Rate)'
        ];
        $this->set(compact('earning', 'accounts', 'zimraOptions', 'calculationTypes'));
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
        $earning = $this->fetchTable('Earnings')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $earning = $this->fetchTable('Earnings')->patchEntity($earning, $this->request->getData());
            if ($this->fetchTable('Earnings')->save($earning)) {
                $this->Flash->success(__('The earning has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The earning could not be saved. Please, try again.'));
        }
        $accounts = $this->fetchTable('Earnings')->Accounts->find('list', limit: 200)->all();
        $zimraOptions = \App\Utility\ZimraMapping::getOptions();
        $calculationTypes = [
            'Fixed Amount' => 'Fixed Amount',
            'Percentage of Basic Salary' => 'Percentage of Basic Salary',
            'Hourly/Daily Rate' => 'Hourly/Daily Rate (Units * Rate)'
        ];
        $this->set(compact('earning', 'accounts', 'zimraOptions', 'calculationTypes'));
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
        $earning = $this->fetchTable('Earnings')->get($id);
        if ($this->fetchTable('Earnings')->delete($earning)) {
            $this->Flash->success(__('The earning has been deleted.'));
        } else {
            $this->Flash->error(__('The earning could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
