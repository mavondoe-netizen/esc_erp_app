<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * ZimraReports Controller
 *
 * ZIMRA VAT3 and related report generation for submission to ZIMRA.
 */
class ZimraReportsController extends AppController
{
    /**
     * ZIMRA reports index — list all available reports.
     *
     * @return void
     */
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        $PayPeriods = TableRegistry::getTableLocator()->get('PayPeriods');
        $payPeriods = $PayPeriods->find('list', keyField: 'id', valueField: 'name')
            ->where(['PayPeriods.company_id' => $companyId])
            ->order(['PayPeriods.start_date' => 'DESC'])
            ->all();

        $this->set(compact('payPeriods'));
    }

    /**
     * Generate a ZIMRA report (VAT3, etc.).
     *
     * @return void
     */
    public function generate()
    {
        $companyId = $this->request->getAttribute('company_id');

        $PayPeriods = TableRegistry::getTableLocator()->get('PayPeriods');
        $periods = $PayPeriods->find('list', keyField: 'id', valueField: 'name')
            ->where(['PayPeriods.company_id' => $companyId])
            ->order(['PayPeriods.start_date' => 'DESC'])
            ->all();

        $startDate = $this->request->getQuery('start_date', date('Y-01-01'));
        $endDate   = $this->request->getQuery('end_date', date('Y-m-d'));
        $reportType = $this->request->getQuery('type', 'VAT3');

        // Gather transaction data for the report
        $conn = TableRegistry::getTableLocator()->get('Transactions')->getConnection();

        // Standard output / sales tax collected (Credits to Income accounts)
        $outputSql = "SELECT SUM(t.amount) as total
                      FROM transactions t
                      JOIN accounts a ON a.id = t.account_id
                      WHERE t.company_id = :cid
                        AND t.date BETWEEN :start AND :end
                        AND t.type IN ('Credit','2')
                        AND a.type IN ('Income','Revenue')";

        $inputSql  = "SELECT SUM(t.amount) as total
                      FROM transactions t
                      JOIN accounts a ON a.id = t.account_id
                      WHERE t.company_id = :cid
                        AND t.date BETWEEN :start AND :end
                        AND t.type IN ('Debit','1')
                        AND a.type = 'Expense'";

        $outputStmt = $conn->execute($outputSql, [':cid' => $companyId, ':start' => $startDate, ':end' => $endDate]);
        $inputStmt  = $conn->execute($inputSql,  [':cid' => $companyId, ':start' => $startDate, ':end' => $endDate]);

        $outputTotal = (float)($outputStmt->fetch('assoc')['total'] ?? 0);
        $inputTotal  = (float)($inputStmt->fetch('assoc')['total'] ?? 0);

        // VAT3 at 15% standard rate
        $vatRate     = 0.15;
        $outputVat   = $outputTotal * $vatRate;
        $inputVat    = $inputTotal  * $vatRate;
        $netVat      = $outputVat - $inputVat;

        // Generate PAYE Report Data
        $payPeriodId = $this->request->getData('pay_period_id') ?: $this->request->getQuery('pay_period_id');
        $payPeriod = null;
        $reportData = [];

        if ($payPeriodId) {
            $payPeriod = $PayPeriods->get($payPeriodId);
            $Payslips = TableRegistry::getTableLocator()->get('Payslips');
            $payslips = $Payslips->find()
                ->where([
                    'Payslips.company_id'   => $companyId,
                    'Payslips.pay_period_id' => $payPeriodId,
                ])
                ->contain(['Employees'])
                ->all();

            foreach ($payslips as $slip) {
                $reportData[] = [
                    'Emp Code' => $slip->employee->employee_code,
                    'Employee Name' => trim($slip->employee->first_name . ' ' . $slip->employee->last_name),
                    'National ID' => $slip->employee->national_id,
                    'Current Salary, wages, fees, Commissions etc (regular earnings) USD' => $slip->basic_salary,
                    'Other Exemptions on Current Salary, Wages, Fees, Commissions Etc (Regular Earnings) USD' => 0.00,
                    'Current Overtime USD' => 0.00,
                    'Current Bonus USD' => 0.00,
                    'Current Irregular Commission USD' => 0.00,
                    'Current Other Irregular earnings USD' => 0.00,
                    'Current Severance pay, gratuity or similar benefit, on retrenchment (with exemption) USD' => 0.00,
                    'Current Gratuity without exemption USD' => 0.00,
                    'Current Housing Benefit USD' => 0.00,
                    'Current Vehicle Benefit USD' => 0.00,
                    'Current Education Benefit USD' => 0.00,
                    'Current Other Benefits USD' => $slip->allowances,
                    'Current Non-Taxable Earnings USD' => 0.00,
                    'Current Pension Contributions USD' => $slip->pension,
                    'Current NSSA Contributions USD' => $slip->nssa,
                    'Current Retirement Annuity Fund Contributions USD' => 0.00,
                    'Current NLC/Subscriptions USD' => 0.00,
                    'Current Other Deductions USD' => 0.00,
                    'Current Medical Aid Contributions USD' => $slip->medical_aid,
                    'Current Medical Expenses USD' => 0.00,
                    'Current Blind persons credit USD' => 0.00,
                    'Current Disabled persons credit USD' => 0.00,
                    'Current Elderly person credit USD' => 0.00,
                    'Cumulative Bonus (from last tax period) USD' => 0.00,
                    'Total Taxable Income USD' => $slip->taxable_income,
                    'PAYE USD' => $slip->paye,
                    'AIDS Levy USD' => $slip->aids_levy,
                    'Total Tax USD' => (float)$slip->paye + (float)$slip->aids_levy,
                    'Net Pay USD' => $slip->net_pay,
                ];
            }
        }

        $this->set(compact(
            'periods', 'startDate', 'endDate', 'reportType',
            'outputTotal', 'inputTotal', 'outputVat', 'inputVat', 'netVat', 'vatRate',
            'payPeriod', 'reportData'
        ));
    }
}
