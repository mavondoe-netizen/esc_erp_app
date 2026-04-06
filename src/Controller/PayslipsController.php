<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\PayrollService;

/**
 * Payslips Controller
 *
 * @property \App\Model\Table\PayslipsTable $Payslips
 */
class PayslipsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->fetchTable('Payslips')->find()
            ->contain([
                'Employees', 
                'PayPeriods', 
                // Contain items and order them nicely for display
                'PayslipItems' => function($q) {
                    return $q->order(['item_type' => 'ASC', 'name' => 'ASC']);
                }
            ])
            ->order(['PayPeriods.start_date' => 'DESC', 'Employees.employee_code' => 'ASC']);
            
        $payslips = $this->paginate($query);

        // Pre-calculate unique dynamic columns across the paginated set
        $dynamicColumns = [
            'Earnings' => [],
            'Deductions' => [],
            'Taxes' => []
        ];

        foreach ($payslips as $payslip) {
            foreach ($payslip->payslip_items as $item) {
                if ($item->item_type === 'Earning') {
                    $dynamicColumns['Earnings'][$item->name] = $item->name;
                } elseif ($item->item_type === 'Deduction') {
                    $dynamicColumns['Deductions'][$item->name] = $item->name;
                } elseif ($item->item_type === 'Tax') {
                    $dynamicColumns['Taxes'][$item->name] = $item->name;
                }
            }
        }

        // Sort them alphabetically for consistent UI rendering
        asort($dynamicColumns['Earnings']);
        asort($dynamicColumns['Deductions']);
        asort($dynamicColumns['Taxes']);

        $groupedPayslips = collection($payslips)->groupBy(function ($payslip) {
            return $payslip->hasValue('pay_period') ? $payslip->pay_period->name : 'Unknown Period';
        })->toArray();

        $this->set(compact('payslips', 'groupedPayslips', 'dynamicColumns'));
    }

    /**
     * View method
     *
     * @param string|null $id Payslip id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payslip = $this->fetchTable('Payslips')->get($id, contain: ['Employees', 'PayPeriods', 'PayslipItems']);
        
        // Fetch Leave Balances for the Payslip Year
        $year = (int)$payslip->generated_date->format('Y');
        $leaveBalances = $this->fetchTable('LeaveBalances')->find()
            ->where(['employee_id' => $payslip->employee_id, 'year' => $year])
            ->contain(['LeaveTypes'])
            ->all();

        $this->set(compact('payslip', 'leaveBalances'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payslip = $this->fetchTable('Payslips')->newEmptyEntity();
        
        // Auto-assign the globally active Current Pay Period
        $activePeriod = $this->fetchTable('PayPeriods')->find()->where(['status' => 'Current'])->first();
        if ($activePeriod) {
            $payslip->pay_period_id = $activePeriod->id;
        }

        if ($this->request->is('post')) {
            $payslip = $this->fetchTable('Payslips')->patchEntity($payslip, $this->request->getData(), ['associated' => ['PayslipItems']]);
            if ($this->fetchTable('Payslips')->save($payslip)) {
                $this->Flash->success(__('The payslip has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            \Cake\Log\Log::error('Payslip save failed in add: ' . print_r($payslip->getErrors(), true));
            $this->Flash->error(__('The payslip could not be saved. Please, try again.'));
        }
        $employees = $this->fetchTable('Payslips')->Employees->find('list', limit: 500)->where(['disabled' => 0])->all();
        $payPeriods = $this->fetchTable('Payslips')->PayPeriods->find('list', limit: 200)->all();
        $systemEarningsRecords = $this->fetchTable('Earnings')->find()->all();
        $systemEarnings = [];
        $earningsMetadata = [];
        foreach ($systemEarningsRecords as $er) {
            $systemEarnings[$er->name] = $er->name;
            $earningsMetadata[$er->name] = [
                'is_gross_up' => (bool)$er->gross_up,
                'is_fringe' => (stripos($er->name, 'fringe') !== false || stripos($er->name, 'airtime') !== false)
            ];
        }
        $systemDeductions = $this->fetchTable('Deductions')->find('list', valueField: 'name', keyField: 'name')->toArray();
        $this->set(compact('payslip', 'employees', 'payPeriods', 'systemEarnings', 'earningsMetadata', 'systemDeductions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payslip id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payslip = $this->fetchTable('Payslips')->get($id, contain: ['PayslipItems', 'PayPeriods']);
        
        // Compliance Firewall: Lock historical edits
        if ($payslip->hasValue('pay_period') && $payslip->pay_period->get('status') === 'Previous') {
            $this->Flash->error(__('This payslip belongs to a closed Pay Period and cannot be edited. Please reverse or issue an adjustment in the current period.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $payslip = $this->fetchTable('Payslips')->patchEntity($payslip, $this->request->getData(), ['associated' => ['PayslipItems']]);
            if ($this->fetchTable('Payslips')->save($payslip)) {
                $this->Flash->success(__('The payslip has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            \Cake\Log\Log::error('Payslip save failed in edit: ' . print_r($payslip->getErrors(), true));
            $this->Flash->error(__('The payslip could not be saved. Please, try again.'));
        }
        $employees = $this->fetchTable('Payslips')->Employees->find('list', limit: 500)->where(['disabled' => 0])->all();
        $payPeriods = $this->fetchTable('Payslips')->PayPeriods->find('list', limit: 200)->all();
        $systemEarningsRecords = $this->fetchTable('Earnings')->find()->all();
        $systemEarnings = [];
        $earningsMetadata = [];
        foreach ($systemEarningsRecords as $er) {
            $systemEarnings[$er->name] = $er->name;
            $earningsMetadata[$er->name] = [
                'is_gross_up' => (bool)$er->gross_up,
                'is_fringe' => (stripos($er->name, 'fringe') !== false || stripos($er->name, 'airtime') !== false)
            ];
        }
        $systemDeductions = $this->fetchTable('Deductions')->find('list', valueField: 'name', keyField: 'name')->toArray();
        $this->set(compact('payslip', 'employees', 'payPeriods', 'systemEarnings', 'earningsMetadata', 'systemDeductions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payslip id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payslip = $this->fetchTable('Payslips')->get($id);
        if ($this->fetchTable('Payslips')->delete($payslip)) {
            $this->Flash->success(__('The payslip has been deleted.'));
        } else {
            $this->Flash->error(__('The payslip could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * AJAX Endpoint to calculate statutory taxes from dynamic line items
     * 
     * @return \Cake\Http\Response|null Returns JSON response
     */
    public function calculateTaxes()
    {
        $this->request->allowMethod(['post', 'ajax']);
        
        $items = $this->request->getData('payslip_items', []);
        $exchangeRate = (float)$this->request->getData('exchange_rate', 1.0);
        $employeeId = $this->request->getData('employee_id');
        
        $employee = null;
        if ($employeeId) {
            $employee = $this->fetchTable('Employees')->get($employeeId);
        }
        
        $payrollService = new \App\Service\PayrollService();
        $result = $payrollService->calculateFromItems($items, $exchangeRate, $employee);
        
        return $this->response->withType('application/json')
            ->withStringBody(json_encode([
                'success' => true,
                'data' => $result['taxes'],
                'updated_items' => $result['updated_items']
            ]));
    }

    /**
     * AJAX Endpoint to fetch permanent line items from an employee's most recent payslip
     * 
     * @return \Cake\Http\Response|null Returns JSON response
     */
    public function getPermanentItems()
    {
        $this->request->allowMethod(['get', 'ajax']);
        $employeeId = $this->request->getQuery('employee_id');

        if (!$employeeId) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => false, 'message' => 'Employee ID required']));
        }

        // Find the most recent payslip for this employee
        $lastPayslip = $this->fetchTable('Payslips')->find()
            ->where(['employee_id' => $employeeId])
            ->order(['generated_date' => 'DESC', 'id' => 'DESC'])
            ->contain([
                'PayslipItems' => function ($q) {
                    return $q->where(['is_permanent' => true]);
                }
            ])
            ->first();

        $items = [];
        if ($lastPayslip && !empty($lastPayslip->payslip_items)) {
            foreach ($lastPayslip->payslip_items as $item) {
                $items[] = [
                    'item_type' => $item->item_type,
                    'currency' => $item->currency ?? 'ZWG',
                    'name' => $item->name,
                    'amount' => $item->amount,
                    'is_permanent' => true
                ];
            }
        }

        return $this->response->withType('application/json')
            ->withStringBody(json_encode([
                'success' => true,
                'data' => $items
            ]));
    }
}
