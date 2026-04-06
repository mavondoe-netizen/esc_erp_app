<?php
declare(strict_types=1);

namespace App\Controller;

use App\Utility\ZimraMapping;

/**
 * ZimraReports Controller
 */
class ZimraReportsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $payPeriods = $this->fetchTable('PayPeriods')->find('list', [
            'valueField' => function($row) {
                return $row->name;
            },
            'order' => ['start_date' => 'DESC']
        ])->toArray();
        
        $this->set(compact('payPeriods'));
    }

    /**
     * Generate method
     */
    public function generate()
    {
        if ($this->request->is('post') || $this->request->getQuery('pay_period_id')) {
            $payPeriodId = $this->request->getData('pay_period_id') ?? $this->request->getQuery('pay_period_id');
            
            $payPeriod = $this->fetchTable('PayPeriods')->get($payPeriodId);
            
            // Build aggregations here...
            $reportData = $this->buildReportData((int)$payPeriodId);
            
            $this->set(compact('payPeriod', 'reportData'));
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }

    private function buildReportData(int $payPeriodId): array
    {
        $data = [];
        
        $payslips = $this->fetchTable('Payslips')->find()
            ->where(['pay_period_id' => $payPeriodId])
            ->contain([
                'Employees',
                'PayslipItems'
            ])
            ->all();

        // Load mappings
        $earnings = $this->fetchTable('Earnings')->find()->all()->combine('name', 'zimra_mapping')->toArray();
        $deductions = $this->fetchTable('Deductions')->find()->all()->combine('name', 'zimra_mapping')->toArray();

        foreach ($payslips as $payslip) {
            $employee = $payslip->employee;
            
            $row = [
                'TIN' => $employee->tax_number,
                'ID/Passport Number' => $employee->national_identity ?: $employee->employee_code,
                'Employee Name' => $employee->first_name . ' ' . $employee->last_name,
                'Currency' => 'Mixed', // Wait, usually the employee has a base currency. ZIMRA separates USD and ZWG.
            ];

            // Initialize all amounts to 0
            $options = ZimraMapping::getOptions();
            foreach ($options as $key => $label) {
                $row[$label . ' USD'] = 0.0;
                $row[$label . ' ZWG'] = 0.0;
            }
            
            // Credits are per employee
            // "Current Blind persons credit USD"
            $row['Current Blind persons credit USD'] = $employee->is_blind ? 75.0 : 0.0;
            $row['Current Blind persons credit ZWG'] = 0.0;
            $row['Current Disabled persons credit USD'] = $employee->disabled ? 75.0 : 0.0;
            $row['Current Disabled persons credit ZWG'] = 0.0;
            $row['Current Elderly person credit USD'] = $employee->is_elderly ? 75.0 : 0.0;
            $row['Current Elderly person credit ZWG'] = 0.0;

            foreach ($payslip->payslip_items as $item) {
                $mapLabel = null;
                $currencySuffix = ($item->currency === 'USD') ? ' USD' : ' ZWG';

                if ($item->item_type === 'Earning' && isset($earnings[$item->name]) && $earnings[$item->name]) {
                    $key = $earnings[$item->name];
                    $mapLabel = $options[$key] ?? null;
                } elseif ($item->item_type === 'Deduction' && isset($deductions[$item->name]) && $deductions[$item->name]) {
                    $key = $deductions[$item->name];
                    $mapLabel = $options[$key] ?? null;
                } elseif ($item->item_type === 'Tax') {
                    if ($item->name === 'NSSA') $mapLabel = 'Current NSSA Contributions';
                    if ($item->name === 'Pension') $mapLabel = 'Current Pension Contributions';
                }

                if ($mapLabel) {
                    $column = $mapLabel . $currencySuffix;
                    if (isset($row[$column])) {
                        $row[$column] += (float)$item->amount;
                    }
                }
            }
            
            $data[] = $row;
        }

        return $data;
    }
}
