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

        // ---- Payroll Summaries (Dummy defaults for now) ----
        $totalGross        = 0;
        $totalDeductions   = 0;
        $totalNet          = 0;
        $outstandingLeaves = 0;

        // ---- Property Management Summaries ----
        $Units = TableRegistry::getTableLocator()->get('Units');
        $totalUnits = $Units->find()->where(['Units.company_id' => $companyId])->count();
        
        // Units count based on Units.isvacant status
        $vacantCount = $Units->find()
            ->where(['Units.company_id' => $companyId, 'Units.isvacant' => true])
            ->count();
        
        $occupiedCount = $totalUnits - $vacantCount;
        $occupancyRate = $totalUnits > 0 ? round(($occupiedCount / $totalUnits) * 100, 1) : 0;

        $monthlyRentalIncome = 0; // Requires LeasePayments lookup
        
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

        // ---- Chart Data (Dummy Defaults) ----
        $chartLabels    = [date('M', strtotime('-2 months')), date('M', strtotime('-1 month')), date('M')];
        $grossData      = [0, 0, 0];
        $deductionsData = [0, 0, 0];

        $this->set(compact(
            'totalGross', 'totalDeductions', 'totalNet', 'outstandingLeaves',
            'totalUnits', 'occupiedCount', 'vacantCount', 'occupancyRate', 
            'monthlyRentalIncome', 'openRepairs', 'outstandingLevies',
            'allModules', 'chartLabels', 'grossData', 'deductionsData'
        ));
    }
}
