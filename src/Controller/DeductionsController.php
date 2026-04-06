<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Deductions Controller
 *
 * @property \App\Model\Table\DeductionsTable $Deductions
 */
class DeductionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Deductions')->find();
        $deductions = $this->paginate($query);

        $zimraOptions = \App\Utility\ZimraMapping::getOptions();
        $this->set(compact('deductions', 'zimraOptions'));
    }

    /**
     * View method
     *
     * @param string|null $id Deduction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $deduction = $this->fetchTable('Deductions')->get($id, contain: []);
        $this->set(compact('deduction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deduction = $this->fetchTable('Deductions')->newEmptyEntity();
        if ($this->request->is('post')) {
            $deduction = $this->fetchTable('Deductions')->patchEntity($deduction, $this->request->getData());
            if ($this->fetchTable('Deductions')->save($deduction)) {
                $this->Flash->success(__('The deduction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deduction could not be saved. Please, try again.'));
        }
        $accounts = $this->fetchTable('Deductions')->Accounts->find('list', limit: 200)->all();
        $zimraOptions = \App\Utility\ZimraMapping::getOptions();
        $calculationTypes = [
            'Fixed Amount' => 'Fixed Amount',
            'Percentage of Basic Salary' => 'Percentage of Basic Salary',
            'Hourly/Daily Rate' => 'Hourly/Daily Rate (Units * Rate)'
        ];
        $this->set(compact('deduction', 'accounts', 'zimraOptions', 'calculationTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Deduction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $deduction = $this->fetchTable('Deductions')->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deduction = $this->fetchTable('Deductions')->patchEntity($deduction, $this->request->getData());
            if ($this->fetchTable('Deductions')->save($deduction)) {
                $this->Flash->success(__('The deduction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deduction could not be saved. Please, try again.'));
        }
        $accounts = $this->fetchTable('Deductions')->Accounts->find('list', limit: 200)->all();
        $zimraOptions = \App\Utility\ZimraMapping::getOptions();
        $calculationTypes = [
            'Fixed Amount' => 'Fixed Amount',
            'Percentage of Basic Salary' => 'Percentage of Basic Salary',
            'Hourly/Daily Rate' => 'Hourly/Daily Rate (Units * Rate)'
        ];
        $this->set(compact('deduction', 'accounts', 'zimraOptions', 'calculationTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Deduction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $deduction = $this->fetchTable('Deductions')->get($id);
        if ($this->fetchTable('Deductions')->delete($deduction)) {
            $this->Flash->success(__('The deduction has been deleted.'));
        } else {
            $this->Flash->error(__('The deduction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
