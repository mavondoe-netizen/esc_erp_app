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
        $query = $this->Deductions->find()
            ->contain(['Accounts']);
        $deductions = $this->paginate($query);

        $this->set(compact('deductions'));
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
        $deduction = $this->Deductions->get($id, contain: ['Accounts']);
        $this->set(compact('deduction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deduction = $this->Deductions->newEmptyEntity();
        if ($this->request->is('post')) {
            $deduction = $this->Deductions->patchEntity($deduction, $this->request->getData());
            if ($this->Deductions->save($deduction)) {
                $this->Flash->success(__('The deduction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deduction could not be saved. Please, try again.'));
        }
        $accounts = $this->Deductions->Accounts->find('list', limit: 200)->all();
        $calculationTypes = [
            'Fixed Amount' => 'Fixed Amount',
            'Percentage of Total Gross' => 'Percentage of Total Gross',
            'Percentage of Basic' => 'Percentage of Basic Salary',
        ];
        $zimraOptions = [
            'Pension' => 'Pension Contribution',
            'Medical' => 'Medical Aid',
            'Union' => 'Union Dues',
            'Insurance' => 'Insurance',
            'Tax' => 'Income Tax',
        ];
        $this->set(compact('deduction', 'accounts', 'calculationTypes', 'zimraOptions'));
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
        $deduction = $this->Deductions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deduction = $this->Deductions->patchEntity($deduction, $this->request->getData());
            if ($this->Deductions->save($deduction)) {
                $this->Flash->success(__('The deduction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The deduction could not be saved. Please, try again.'));
        }
        $accounts = $this->Deductions->Accounts->find('list', limit: 200)->all();
        $calculationTypes = [
            'Fixed Amount' => 'Fixed Amount',
            'Percentage of Total Gross' => 'Percentage of Total Gross',
            'Percentage of Basic' => 'Percentage of Basic Salary',
        ];
        $zimraOptions = [
            'Pension' => 'Pension Contribution',
            'Medical' => 'Medical Aid',
            'Union' => 'Union Dues',
            'Insurance' => 'Insurance',
            'Tax' => 'Income Tax',
        ];
        $this->set(compact('deduction', 'accounts', 'calculationTypes', 'zimraOptions'));
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
        $deduction = $this->Deductions->get($id);
        if ($this->Deductions->delete($deduction)) {
            $this->Flash->success(__('The deduction has been deleted.'));
        } else {
            $this->Flash->error(__('The deduction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
