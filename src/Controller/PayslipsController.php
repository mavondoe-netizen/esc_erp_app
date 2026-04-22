<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Payslips Controller
 *
 * Payroll management: payslip generation per pay period, individual
 * payslip CRUD, and the ZIMRA PAYE summary.
 */
class PayslipsController extends AppController
{
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Payslips = $this->fetchTable('Payslips');
        $conditions = [];

        $periodId = $this->request->getQuery('pay_period_id');
        if ($periodId) $conditions['Payslips.pay_period_id'] = (int)$periodId;

        $query = $Payslips->find()
            ->where($conditions)
            ->contain(['Employees', 'PayPeriods', 'PayslipItems'])
            ->order(['Payslips.pay_period_id' => 'DESC', 'Employees.first_name' => 'ASC', 'Employees.last_name' => 'ASC']);

        $payslips = $this->paginate($query, ['limit' => 100]);

        $groupedPayslips = [];
        $dynamicColumns  = ['Earnings' => [], 'Deductions' => [], 'Taxes' => []];

        foreach ($payslips as $payslip) {
            $periodName = $payslip->hasValue('pay_period') ? $payslip->pay_period->name : 'Unknown Period';
            $groupedPayslips[$periodName][] = $payslip;

            if (!empty($payslip->payslip_items)) {
                foreach ($payslip->payslip_items as $item) {
                    if ($item->item_type === 'Earning' && !in_array($item->name, $dynamicColumns['Earnings'])) {
                        $dynamicColumns['Earnings'][] = $item->name;
                    } elseif ($item->item_type === 'Deduction' && !in_array($item->name, $dynamicColumns['Deductions'])) {
                        $dynamicColumns['Deductions'][] = $item->name;
                    } elseif ($item->item_type === 'Tax' && !in_array($item->name, $dynamicColumns['Taxes'])) {
                        $dynamicColumns['Taxes'][] = $item->name;
                    }
                }
            }
        }

        $PayPeriods = $this->fetchTable('PayPeriods');
        $payPeriods = $PayPeriods->find('list', keyField: 'id', valueField: 'name')
            ->where(['PayPeriods.company_id' => $companyId])
            ->order(['PayPeriods.start_date' => 'DESC'])
            ->all();

        $this->set(compact('payslips', 'groupedPayslips', 'dynamicColumns', 'payPeriods'));
    }

    public function view(int $id)
    {
        $payslip = $this->fetchTable('Payslips')
            ->get($id, contain: ['Employees', 'PayPeriods', 'PayslipItems']);
        $this->set(compact('payslip'));
    }

    public function add()
    {
        $companyId = $this->request->getAttribute('company_id');

        $Payslips = $this->fetchTable('Payslips');
        $payslip  = $Payslips->newEmptyEntity();

        if ($this->request->is('post')) {
            $data               = $this->request->getData();
            $data['company_id'] = $companyId;
            $payslip = $Payslips->patchEntity($payslip, $data, [
                'associated' => ['PayslipItems']
            ]);
            if ($Payslips->save($payslip)) {
                $this->Flash->success(__('Payslip saved.'));
                return $this->redirect(['action' => 'view', $payslip->id]);
            }
            $this->Flash->error(__('Could not save payslip.'));
        }

        [$employees, $payPeriods] = $this->_dropdowns($companyId);
        
        $systemEarnings = $this->fetchTable('Earnings')->find('list', valueField: 'name')->all()->toArray();
        $systemDeductions = $this->fetchTable('Deductions')->find('list', valueField: 'name')->all()->toArray();
        
        $earningsMetadata = $this->fetchTable('Earnings')->find()
            ->select(['name', 'gross_up', 'taxable'])
            ->all()
            ->indexBy('name')
            ->toArray();

        $this->set(compact('payslip', 'employees', 'payPeriods', 'systemEarnings', 'systemDeductions', 'earningsMetadata'));
    }

    public function edit(int $id)
    {
        $companyId = $this->request->getAttribute('company_id');

        $Payslips = $this->fetchTable('Payslips');
        $payslip  = $Payslips->get($id, contain: ['PayslipItems']);

        if ($this->request->is(['post', 'put'])) {
            $payslip = $Payslips->patchEntity($payslip, $this->request->getData(), [
                'associated' => ['PayslipItems']
            ]);
            if ($Payslips->save($payslip)) {
                $this->Flash->success(__('Payslip updated.'));
                return $this->redirect(['action' => 'view', $payslip->id]);
            }
            $this->Flash->error(__('Could not update payslip.'));
        }

        [$employees, $payPeriods] = $this->_dropdowns($companyId);
        
        $systemEarnings = $this->fetchTable('Earnings')->find('list', valueField: 'name')->all()->toArray();
        $systemDeductions = $this->fetchTable('Deductions')->find('list', valueField: 'name')->all()->toArray();

        $earningsMetadata = $this->fetchTable('Earnings')->find()
            ->select(['name', 'gross_up', 'taxable'])
            ->all()
            ->indexBy('name')
            ->toArray();

        $this->set(compact('payslip', 'employees', 'payPeriods', 'systemEarnings', 'systemDeductions', 'earningsMetadata'));
    }

    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $Payslips = $this->fetchTable('Payslips');
        $payslip  = $Payslips->get($id);

        if ($Payslips->delete($payslip)) {
            $this->Flash->success(__('Payslip deleted.'));
        } else {
            $this->Flash->error(__('Could not delete payslip.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getPermanentItems()
    {
        $this->request->allowMethod(['get']);
        $employeeId = $this->request->getQuery('employee_id');
        $employee = $this->fetchTable('Employees')->get($employeeId);

        $items = [];
        if ($employee->basic_salary > 0) {
            $items[] = [
                'item_type' => 'Earning',
                'name' => 'Basic Salary',
                'amount' => $employee->basic_salary,
                'currency' => 'USD',
                'is_permanent' => true
            ];
        }

        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'data' => $items]));
    }

    public function calculateTaxes()
    {
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();
        $items = $data['payslip_items'] ?? [];
        $rate = (float)($data['exchange_rate'] ?? 1.0);

        $usdGross = 0; $zwgGross = 0;
        $usdBasic = 0; $zwgBasic = 0;

        foreach($items as $item) {
            if ($item['item_type'] === 'Earning') {
                $amt = (float)$item['amount'];
                $isBasic = stripos($item['name'] ?? '', 'Basic Salary') !== false;

                if ($item['currency'] === 'USD') {
                    $usdGross += $amt;
                    if ($isBasic) $usdBasic += $amt;
                } else if ($item['currency'] === 'ZWG') {
                    $zwgGross += $amt;
                    if ($isBasic) $zwgBasic += $amt;
                }
            }
        }

        $totalUsdGross = $usdGross + ($zwgGross / $rate);
        $totalUsdBasic = $usdBasic + ($zwgBasic / $rate);

        if ($totalUsdGross <= 0) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['success' => true, 'data' => []]));
        }

        // Proportions for General Taxes (PAYE, Aids Levy)
        $usdWeightGen = $usdGross / $totalUsdGross;
        $zwgWeightGen = 1.0 - $usdWeightGen;

        // Proportions for NSSA (based on Basic Salary)
        if ($totalUsdBasic > 0) {
            $usdWeightNssa = $usdBasic / $totalUsdBasic;
            $zwgWeightNssa = 1.0 - $usdWeightNssa;
        } else {
            // Fallback to general weights if no basic salary identified
            $usdWeightNssa = $usdWeightGen;
            $zwgWeightNssa = $zwgWeightGen;
        }

        $totalPayeUsd = $this->_calculatePaye($totalUsdGross);
        $totalNssaUsd = $totalUsdBasic * 0.045; // 4.5% of basic
        if ($totalNssaUsd > 31.50) $totalNssaUsd = 31.50; // Cap at $31.50

        $totalAidsUsd = $totalPayeUsd * 0.03;

        $taxes = [];

        // Split PAYE
        if ($totalPayeUsd > 0) {
            if ($usdWeightGen > 0) {
                $taxes[] = ['item_type' => 'Tax', 'name' => 'PAYE', 'amount' => round($totalPayeUsd * $usdWeightGen, 2), 'currency' => 'USD', 'is_permanent' => false];
            }
            if ($zwgWeightGen > 0) {
                $taxes[] = ['item_type' => 'Tax', 'name' => 'PAYE', 'amount' => round($totalPayeUsd * $zwgWeightGen * $rate, 2), 'currency' => 'ZWG', 'is_permanent' => false];
            }
        }

        // Split NSSA
        if ($totalNssaUsd > 0) {
            if ($usdWeightNssa > 0) {
                $taxes[] = ['item_type' => 'Tax', 'name' => 'NSSA', 'amount' => round($totalNssaUsd * $usdWeightNssa, 2), 'currency' => 'USD', 'is_permanent' => false];
            }
            if ($zwgWeightNssa > 0) {
                $taxes[] = ['item_type' => 'Tax', 'name' => 'NSSA', 'amount' => round($totalNssaUsd * $zwgWeightNssa * $rate, 2), 'currency' => 'ZWG', 'is_permanent' => false];
            }
        }

        // Split Aids Levy
        if ($totalAidsUsd > 0) {
            if ($usdWeightGen > 0) {
                $taxes[] = ['item_type' => 'Tax', 'name' => 'Aids Levy', 'amount' => round($totalAidsUsd * $usdWeightGen, 2), 'currency' => 'USD', 'is_permanent' => false];
            }
            if ($zwgWeightGen > 0) {
                $taxes[] = ['item_type' => 'Tax', 'name' => 'Aids Levy', 'amount' => round($totalAidsUsd * $zwgWeightGen * $rate, 2), 'currency' => 'ZWG', 'is_permanent' => false];
            }
        }

        return $this->response->withType('application/json')
            ->withStringBody(json_encode(['success' => true, 'data' => $taxes]));
    }

    /**
     * Bulk-generate payslips for all active employees in a pay period.
     */
    public function generate()
    {
        $companyId = $this->request->getAttribute('company_id');

        $PayPeriods = $this->fetchTable('PayPeriods');
        $payPeriods = $PayPeriods->find('list', keyField: 'id', valueField: 'name')
            ->where(['PayPeriods.company_id' => $companyId])
            ->order(['PayPeriods.start_date' => 'DESC'])
            ->all();

        if ($this->request->is('post')) {
            $periodId = (int)$this->request->getData('pay_period_id');

            $period = $PayPeriods->find()
                ->where(['PayPeriods.id' => $periodId, 'PayPeriods.company_id' => $companyId])
                ->first();

            if (!$period) {
                $this->Flash->error('Pay period not found.');
                $this->set(compact('payPeriods'));
                return null;
            }

            $Employees = $this->fetchTable('Employees');
            $employees = $Employees->find()
                ->where(['Employees.disabled' => false])
                ->all();

            $Payslips = $this->fetchTable('Payslips');
            $generated = 0;
            $skipped   = 0;

            foreach ($employees as $employee) {
                $existing = $Payslips->find()
                    ->where([
                        'Payslips.company_id'    => $companyId,
                        'Payslips.employee_id'   => $employee->id,
                        'Payslips.pay_period_id' => $periodId,
                    ])
                    ->first();

                if ($existing) {
                    $skipped++;
                    continue;
                }

                $gross = (float)($employee->basic_salary ?? 0);
                $paye = $this->_calculatePaye($gross);
                $net  = $gross - $paye - ($gross * 0.045) - ($paye * 0.03); // Rough net

                $payslip = $Payslips->newEntity([
                    'company_id'    => $companyId,
                    'employee_id'   => $employee->id,
                    'pay_period_id' => $periodId,
                    'gross_pay'     => $gross,
                    'paye'          => $paye,
                    'net_pay'       => $net,
                    'generated_date' => date('Y-m-d'),
                    'exchange_rate' => 1.0,
                    'usd_gross' => $gross,
                    'usd_deductions' => $gross - $net,
                    'usd_net' => $net,
                    'status'        => 'Draft',
                ], ['validate' => false]);

                if ($Payslips->save($payslip)) {
                    $generated++;
                }
            }

            $this->Flash->success("Generated $generated payslip(s). $skipped skipped.");
            return $this->redirect(['action' => 'index', '?' => ['pay_period_id' => $periodId]]);
        }

        $earnings = $this->fetchTable('Earnings')->find()->all();
        $deductions = $this->fetchTable('Deductions')->find()->all();

        $this->set(compact('payPeriods', 'earnings', 'deductions'));
    }

    private function _calculatePaye(float $gross): float
    {
        if ($gross <= 300)    return 0.0;
        if ($gross <= 700)    return ($gross - 300) * 0.20;
        if ($gross <= 1500)   return 80 + ($gross - 700) * 0.25;
        if ($gross <= 3000)   return 280 + ($gross - 1500) * 0.30;
        return 730 + ($gross - 3000) * 0.35;
    }

    private function _dropdowns(int $companyId): array
    {
        $employees = $this->fetchTable('Employees')
            ->find()
            ->where(['Employees.disabled' => false])
            ->all()
            ->combine('id', 'name')
            ->toArray();

        $payPeriods = $this->fetchTable('PayPeriods')
            ->find()
            ->order(['PayPeriods.start_date' => 'DESC'])
            ->all()
            ->combine('id', 'name')
            ->toArray();

        return [$employees, $payPeriods];
    }
}
