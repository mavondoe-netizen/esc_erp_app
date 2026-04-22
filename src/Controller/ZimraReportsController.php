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

        $this->set(compact(
            'periods', 'startDate', 'endDate', 'reportType',
            'outputTotal', 'inputTotal', 'outputVat', 'inputVat', 'netVat', 'vatRate'
        ));
    }
}
