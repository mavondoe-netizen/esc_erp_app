<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Dashboard Controller
 *
 * Central hub for the ERP application showing KPIs, recent activity, and quick links.
 */
class DashboardController extends AppController
{
    /**
     * Main dashboard index.
     *
     * @return void
     */
    public function index()
    {
        $companyId = $this->request->getAttribute('company_id');

        // ---- Payroll Summaries (Actual data) ----
        $PayPeriods = TableRegistry::getTableLocator()->get('PayPeriods');
        $Payslips = TableRegistry::getTableLocator()->get('Payslips');
        
        // Find the most recent/active pay period that HAS payslips
        $latestPeriod = $PayPeriods->find()
            ->innerJoinWith('Payslips')
            ->where(['PayPeriods.company_id' => $companyId])
            ->order(['PayPeriods.end_date' => 'DESC'])
            ->first();
        
        // Fallback to the absolute latest period if no payslips found anywhere
        if (!$latestPeriod) {
            $latestPeriod = $PayPeriods->find()
                ->where(['PayPeriods.company_id' => $companyId])
                ->order(['PayPeriods.end_date' => 'DESC'])
                ->first();
        }

        $totalGross      = 0;
        $totalDeductions = 0;
        $totalNet        = 0;

        if ($latestPeriod) {
            $summaries = $Payslips->find()
                ->select([
                    'gross' => $Payslips->find()->func()->sum('gross_pay'),
                    'deduc' => $Payslips->find()->func()->sum('deductions'),
                    'net'   => $Payslips->find()->func()->sum('net_pay')
                ])
                ->where(['Payslips.pay_period_id' => $latestPeriod->id])
                ->first();
            
            if ($summaries) {
                $totalGross      = (float)$summaries->get('gross');
                $totalDeductions = (float)$summaries->get('deduc');
                $totalNet        = (float)$summaries->get('net');
            }
        }

        try {
            $LeaveApplications = TableRegistry::getTableLocator()->get('LeaveApplications');
            $outstandingLeaves = $LeaveApplications->find()
                ->where(['LeaveApplications.company_id' => $companyId, 'LeaveApplications.status' => 'Pending'])
                ->count();
        } catch (\Exception $e) {
            $outstandingLeaves = 0;
        }

        // ---- Property Management Summaries ----
        $Units = TableRegistry::getTableLocator()->get('Units');
        $totalUnits = $Units->find()->where(['Units.company_id' => $companyId])->count();
        
        // Units count based on Units.isvacant status
        $vacantCount = $Units->find()
            ->where(['Units.company_id' => $companyId, 'Units.isvacant' => true])
            ->count();
        
        $occupiedCount = $totalUnits - $vacantCount;
        $occupancyRate = $totalUnits > 0 ? round(($occupiedCount / $totalUnits) * 100, 1) : 0;

        $monthlyRentalIncome = 0;
        try {
            $LeasePayments = TableRegistry::getTableLocator()->get('LeasePayments');
            $startOfMonth = date('Y-m-01');
            $endOfMonth = date('Y-m-t');
            
            $rentSum = $LeasePayments->find()
                ->select(['total' => $LeasePayments->find()->func()->sum('amount')])
                ->where([
                    'LeasePayments.company_id' => $companyId,
                    'LeasePayments.date >=' => $startOfMonth,
                    'LeasePayments.date <=' => $endOfMonth
                ])
                ->first();
            
            if ($rentSum) {
                $monthlyRentalIncome = (float)$rentSum->get('total');
            }
        } catch (\Exception $e) {
            $monthlyRentalIncome = 0;
        }
        
        try {
            $Repairs = TableRegistry::getTableLocator()->get('Repairs');
            $openRepairs = $Repairs->find()->where(['Repairs.company_id' => $companyId, 'Repairs.status NOT IN' => ['Completed', 'Closed']])->count();
        } catch (\Exception $e) {
            $openRepairs = 0;
        }

        try {
            $Levies = TableRegistry::getTableLocator()->get('Levies');
            $outstandingLevies = $Levies->find()->where(['Levies.company_id' => $companyId, 'Levies.paid' => 0])->count();
        } catch (\Exception $e) {
            $outstandingLevies = 0;
        }

        // ---- Active Modules ----
        $Modules = TableRegistry::getTableLocator()->get('Modules');
        $allModules = $Modules->find()
            ->where(['Modules.company_id' => $companyId])
            ->order(['Modules.name' => 'ASC'])
            ->all();

        // ---- Chart Data (Last 6 Pay Periods) ----
        $chartLabels    = [];
        $grossData      = [];
        $deductionsData = [];

        $recentPeriods = $PayPeriods->find()
            ->where(['PayPeriods.company_id' => $companyId])
            ->order(['PayPeriods.end_date' => 'DESC'])
            ->limit(6)
            ->all()
            ->toArray();
        
        $recentPeriods = array_reverse($recentPeriods); // Show chronologically


        foreach ($recentPeriods as $period) {
            $monthlySummary = $Payslips->find()
                ->select([
                    'gross' => $Payslips->find()->func()->sum('gross_pay'),
                    'deduc' => $Payslips->find()->func()->sum('deductions')
                ])
                ->where(['Payslips.pay_period_id' => $period->id])
                ->first();
            
            $chartLabels[]    = $period->name;
            $grossData[]      = $monthlySummary ? (float)$monthlySummary->get('gross') : 0;
            $deductionsData[] = $monthlySummary ? (float)$monthlySummary->get('deduc') : 0;
        }

        $this->set(compact(
            'totalGross', 'totalDeductions', 'totalNet', 'outstandingLeaves',
            'totalUnits', 'occupiedCount', 'vacantCount', 'occupancyRate', 
            'monthlyRentalIncome', 'openRepairs', 'outstandingLevies',
            'allModules', 'chartLabels', 'grossData', 'deductionsData'
        ));
    }
}
