<?php
declare(strict_types=1);

namespace App\Controller;

class DashboardController extends AppController
{
    public function index()
    {
        $payslipsTable = $this->fetchTable('Payslips');
        $leaveBalancesTable = $this->fetchTable('LeaveBalances');
        $modulesTable = $this->fetchTable('Modules');
        $exchangeRatesTable = $this->fetchTable('ExchangeRates');
        
        $allModules = $modulesTable->find()->all();
        
        $targetCurrency = $this->request->getQuery('currency', 'USD');
        $ratesList = [];
        if ($targetCurrency !== 'USD') {
            $ratesList = $exchangeRatesTable->find()
                ->where(['currency' => $targetCurrency])
                ->order(['date' => 'DESC'])
                ->all();
        }

        $convert = function($amount, $dateStr) use ($targetCurrency, $ratesList) {
            if ($targetCurrency === 'USD') return (float)$amount;
            $applicableRate = 1.0;
            foreach ($ratesList as $r) {
                if ($r->date->format('Y-m-d') <= $dateStr) {
                    $applicableRate = (float)$r->rate_to_base;
                    break;
                }
            }
            return (float)$amount * $applicableRate;
        };

        // 4. Leave Balances Sum (Unaffected by Currency)
        $leavesQuery = $leaveBalancesTable->find();
        $totalLeaveEntitled = $leavesQuery->select(['total' => $leavesQuery->func()->sum('days_entitled')])->first()->total ?? 0;
        $leavesTakenQuery = $leaveBalancesTable->find();
        $totalLeaveTaken = $leavesTakenQuery->select(['total' => $leavesTakenQuery->func()->sum('days_taken')])->first()->total ?? 0;
        $outstandingLeaves = max(0, $totalLeaveEntitled - $totalLeaveTaken);

        // Fetch all payslips summarized by pay period for both overall totals & chart data
        $query = $payslipsTable->find();
        $chartDataQuery = $query
            ->select([
                'pay_period_name' => 'PayPeriods.name',
                'pay_period_date' => 'PayPeriods.start_date',
                'total_gross' => $query->func()->sum('Payslips.gross_pay'),
                'total_deductions' => $query->func()->sum('Payslips.deductions'),
                'total_net' => $query->func()->sum('Payslips.net_pay')
            ])
            ->contain(['PayPeriods'])
            ->group(['Payslips.pay_period_id', 'PayPeriods.name', 'PayPeriods.start_date'])
            ->order(['PayPeriods.start_date' => 'ASC'])
            ->all();

        $totalGross = 0;
        $totalDeductions = 0;
        $totalNet = 0;
        
        $chartLabels = [];
        $grossData = [];
        $deductionsData = [];

        // Note: The chart logic previously limited to 6, let's keep chart limited to recent 6 
        // but globals should ideally encompass all. Since dashboard originally showed all, we'll slice the array for charts
        $allData = $chartDataQuery->toArray();
        
        foreach ($allData as $row) {
            $pDate = $row->pay_period_date->format('Y-m-d');
            $cGross = $convert($row->total_gross, $pDate);
            $cDeductions = $convert($row->total_deductions, $pDate);
            $cNet = $convert($row->total_net, $pDate);
            
            $totalGross += $cGross;
            $totalDeductions += $cDeductions;
            $totalNet += $cNet;
        }

        $chartSlice = array_slice($allData, -6); // last 6 periods
        foreach ($chartSlice as $row) {
            $pDate = $row->pay_period_date->format('Y-m-d');
            $chartLabels[] = $row->pay_period_name;
            $grossData[] = $convert($row->total_gross, $pDate);
            $deductionsData[] = $convert($row->total_deductions, $pDate);
        }

        // ---- PROPERTY MANAGEMENT WIDGETS ----
        $unitsTable       = $this->fetchTable('Units');
        $enrolmentsTable  = $this->fetchTable('Enrolments');
        $leasePaymentsTable = $this->fetchTable('LeasePayments');
        $repairsTable     = $this->fetchTable('Repairs');
        $leviesTable      = $this->fetchTable('Levies');

        $totalUnits   = $unitsTable->find()->count();
        $occupiedCount = $enrolmentsTable->find()->where(['status' => 'Active'])->count();
        $vacantCount  = max(0, $totalUnits - $occupiedCount);
        $occupancyRate = $totalUnits > 0 ? round(($occupiedCount / $totalUnits) * 100, 1) : 0;

        // Rental income this calendar month
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');
        $monthlyRentalIncome = $leasePaymentsTable->find()
            ->select(['total' => $leasePaymentsTable->find()->func()->sum('amount')])
            ->where(['date >=' => $monthStart, 'date <=' => $monthEnd, 'currency' => 'USD'])
            ->first()->total ?? 0;

        $openRepairs  = $repairsTable->find()->where(['status IN' => ['Reported', 'In Progress']])->count();
        $outstandingLevies = $leviesTable->find()->where(['paid' => false])->count();

        $this->set(compact(
            'totalGross',
            'totalDeductions',
            'totalNet',
            'outstandingLeaves',
            'chartLabels',
            'grossData',
            'deductionsData',
            'allModules',
            'targetCurrency',
            'totalUnits',
            'occupiedCount',
            'vacantCount',
            'occupancyRate',
            'monthlyRentalIncome',
            'openRepairs',
            'outstandingLevies'
        ));
    }
}

